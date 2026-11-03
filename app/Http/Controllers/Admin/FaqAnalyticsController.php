<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqApiKey;
use App\Models\FaqChatLog;
use App\Models\FaqUnansweredQuestion;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FaqAnalyticsController extends Controller
{
    /**
     * Display the FAQ & AI Chat Analytics / Monitoring Dashboard.
     */
    public function index(Request $request)
    {
        // 1. Overall Metrics
        $totalSessions = FaqChatLog::distinct('session_id')->count('session_id');
        $totalQuestions = FaqChatLog::where('question', 'not like', 'action:%')
            ->where('question', 'not like', 'feedback:%')
            ->count();

        // Tingkat Membantu / Rating Puas (Dihitung murni dari Like vs Dislike yang diberikan pengguna)
        $likeCount = FaqChatLog::where('feedback_status', 'helped')->count();
        $dislikeCount = FaqChatLog::where('feedback_status', 'not_helped')->count();
        $totalFeedback = $likeCount + $dislikeCount;
        $helprate = $totalFeedback > 0 ? (int) round(($likeCount / $totalFeedback) * 100) : 0;

        $templateCount = FaqChatLog::where('source', 'template')->count();
        $aiCount = FaqChatLog::where('source', 'ai_search')->count();
        $totalAnswers = $templateCount + $aiCount;
        $templatePct = $totalAnswers > 0 ? (int) round(($templateCount / $totalAnswers) * 100) : 0;
        $aiPct = $totalAnswers > 0 ? (100 - $templatePct) : 0;

        $likePct = $totalFeedback > 0 ? (int) round(($likeCount / $totalFeedback) * 100) : 0;
        $dislikePct = $totalFeedback > 0 ? (100 - $likePct) : 0;

        // Perlu Evaluasi: Hanya hitung item yang BELUM ditinjau/selesai oleh admin (is_reviewed = false)
        $ticketEscalations = FaqChatLog::where('escalation_action', 'create_ticket')
            ->where('is_reviewed', false)
            ->distinct('session_id')
            ->count('session_id');

        $pendingDislikeCount = FaqChatLog::where('feedback_status', 'not_helped')
            ->where('is_reviewed', false)
            ->count();

        $pendinglikeCount = FaqChatLog::where('feedback_status', 'helped')
            ->where('is_reviewed', false)
            ->count();
        $pendingLikeCount = $pendinglikeCount;

        $adminRedirects = FaqChatLog::where('escalation_action', 'contact_admin')
            ->distinct('session_id')
            ->count('session_id');

        // 2. Token Vault & Quota Management (Baku Flash Lite = 1500 RPD)
        $geminiDailyLimit = 1500;

        // Auto-seed current .env key to DB if table is empty
        $envKey = (string) config('services.gemini.api_key', env('GEMINI_API_KEY', ''));
        if (FaqApiKey::count() === 0 && !empty($envKey)) {
            FaqApiKey::create([
                'name' => 'Kunci Utama (Default)',
                'api_key' => $envKey,
                'is_active' => true,
                'daily_limit' => $geminiDailyLimit,
                'model' => 'gemini-3.5-flash',
            ]);
        }

        $savedApiKeys = FaqApiKey::orderByDesc('is_active')->latest()->get();
        $activeKeyRecord = FaqApiKey::where('is_active', true)->first();

        $activeApiKey = $activeKeyRecord ? $activeKeyRecord->api_key : $envKey;
        $activeKeyName = $activeKeyRecord ? $activeKeyRecord->name : 'Kunci Utama';

        $maskedApiKey = !empty($activeApiKey)
            ? (strlen($activeApiKey) >= 12
                ? substr($activeApiKey, 0, 8) . '••••••••••••' . substr($activeApiKey, -4)
                : '••••••••')
            : 'Belum Terpasang';

        $activeModel = $activeKeyRecord && !empty($activeKeyRecord->model) ? $activeKeyRecord->model : 'gemini-3.5-flash';

        // AI Request Quota: Counted today (resets every day automatically)
        $aiRequestsToday = FaqChatLog::where('source', 'ai_search')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $aiRequestsThisMonth = FaqChatLog::where('source', 'ai_search')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $geminiUsagePercent = $geminiDailyLimit > 0 ? min(100, round(($aiRequestsToday / $geminiDailyLimit) * 100, 1)) : 0;

        // Compute per-key quota & availability statistics
        foreach ($savedApiKeys as $keyItem) {
            $keyLimit = $keyItem->daily_limit ?: $geminiDailyLimit;

            $callsToday = FaqChatLog::where('source', 'ai_search')
                ->where('api_key_id', $keyItem->id)
                ->whereDate('created_at', Carbon::today())
                ->count();

            // Include legacy unassigned logs today for the active key
            if ($keyItem->is_active) {
                $unassignedToday = FaqChatLog::where('source', 'ai_search')
                    ->whereNull('api_key_id')
                    ->whereDate('created_at', Carbon::today())
                    ->count();
                $callsToday += $unassignedToday;
            }

            $remainingCalls = max(0, $keyLimit - $callsToday);
            $usedPercent = $keyLimit > 0 ? min(100, round(($callsToday / $keyLimit) * 100, 1)) : 0;
            $availablePercent = max(0, round(100 - $usedPercent, 1));
            $isLimitExceeded = ($remainingCalls <= 0 || $usedPercent >= 100);

            $keyItem->calls_today = $callsToday;
            $keyItem->remaining = $remainingCalls;
            $keyItem->used_percent = $usedPercent;
            $keyItem->available_percent = $availablePercent;
            $keyItem->is_limit_exceeded = $isLimitExceeded;

            if ($isLimitExceeded) {
                $keyItem->status_badge = 'danger';
                $keyItem->status_label = 'Limit Tercapai';
            } elseif ($availablePercent <= 20) {
                $keyItem->status_badge = 'warning';
                $keyItem->status_label = 'Mendekati Limit';
            } else {
                $keyItem->status_badge = 'success';
                $keyItem->status_label = 'Normal / Siap';
            }
        }

        // Quota Status Level
        $quotaStatus = 'success';
        $quotaStatusText = 'Normal / Aman';
        if ($geminiUsagePercent >= 90) {
            $quotaStatus = 'danger';
            $quotaStatusText = 'Kuota Hampir Penuh (Segera Alihkan Kunci)';
        } elseif ($geminiUsagePercent >= 70) {
            $quotaStatus = 'warning';
            $quotaStatusText = 'Mendekati Batas Kuota Harian (1.500)';
        }

        // 3. Daily Trends (Last 14 Days)
        $dailyData = FaqChatLog::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(14)->startOfDay())
            ->where('question', 'not like', 'action:%')
            ->where('question', 'not like', 'feedback:%')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date')
            ->toArray();

        $dailyLabels = [];
        $dailyValues = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = Carbon::now()->subDays($i)->format('d M');
            $dailyValues[] = $dailyData[$day] ?? 0;
        }

        // 4. Monthly Trends (Current Year)
        $currentYear = Carbon::now()->year;
        $monthlyData = FaqChatLog::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $currentYear)
            ->where('question', 'not like', 'action:%')
            ->where('question', 'not like', 'feedback:%')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyValues[] = $monthlyData[$m] ?? 0;
        }

        // 5. Top Most Asked Questions (Detailed with User Tracking)
        $topQuestions = FaqChatLog::select(
                'question',
                DB::raw('COUNT(*) as count'),
                DB::raw('MAX(created_at) as last_asked_at'),
                DB::raw('MAX(faq_id) as faq_id'),
                DB::raw('MAX(source) as source'),
                DB::raw('MAX(ai_response) as sample_ai_response'),
                DB::raw('MAX(user_id) as last_user_id'),
                DB::raw("GROUP_CONCAT(DISTINCT user_id) as user_ids"),
                DB::raw("SUM(CASE WHEN feedback_status = 'helped' THEN 1 ELSE 0 END) as helpful_count"),
                DB::raw("SUM(CASE WHEN feedback_status = 'not_helped' THEN 1 ELSE 0 END) as unhelpful_count"),
                DB::raw("SUM(CASE WHEN escalation_action = 'create_ticket' THEN 1 ELSE 0 END) as ticket_escalation_count")
            )
            ->where('question', 'not like', 'action:%')
            ->where('question', 'not like', 'feedback:%')
            ->groupBy('question')
            ->orderByDesc('count')
            ->take(50)
            ->get();

        $faqIds = $topQuestions->pluck('faq_id')->filter()->unique();
        $faqs = Faq::whereIn('id', $faqIds)->get()->keyBy('id');

        // Fetch users who asked these top questions
        $allUserIds = collect();
        foreach ($topQuestions as $q) {
            if (!empty($q->user_ids)) {
                $ids = array_filter(explode(',', (string) $q->user_ids));
                $allUserIds = $allUserIds->merge($ids);
            }
            if (!empty($q->last_user_id)) {
                $allUserIds->push($q->last_user_id);
            }
        }
        $usersMap = \App\Models\User::whereIn('id', $allUserIds->unique())->get()->keyBy('id');

        foreach ($topQuestions as $q) {
            $q->faq = $faqs->get($q->faq_id);
            $q->last_user = (!empty($q->last_user_id) && $usersMap->has($q->last_user_id)) ? $usersMap->get($q->last_user_id) : null;

            $qUserList = collect();
            if (!empty($q->user_ids)) {
                foreach (array_filter(explode(',', (string) $q->user_ids)) as $uid) {
                    if ($usersMap->has($uid)) {
                        $qUserList->push($usersMap->get($uid));
                    }
                }
            }
            $q->users = $qUserList;
        }

        // 7. Evaluasi Pertanyaan Perlu Tindak Lanjut (Respon Dislike & Eskalasi Tiket)
        $evaluationLogs = FaqChatLog::with(['user', 'faq'])
            ->where('question', 'not like', 'action:%')
            ->where('question', 'not like', 'feedback:%')
            ->where(function ($q) {
                $q->where('feedback_status', 'not_helped')
                  ->orWhere('escalation_action', 'create_ticket')
                  ->orWhere('escalation_action', 'contact_admin')
                  ->orWhere('is_answer_found', false);
            })
            ->where('is_reviewed', false)
            ->latest('id')
            ->take(15)
            ->get();

        $unansweredQuestions = FaqUnansweredQuestion::where('status', 'pending')
            ->orderByDesc('occurrence_count')
            ->take(5)
            ->get();

        // 8. Recent Gemini AI Chat Logs for Quota Monitoring Tab
        $recentAiLogs = FaqChatLog::where('source', 'ai_search')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin.faq.analytics', compact(
            'totalSessions',
            'totalQuestions',
            'helprate',
            'likeCount',
            'totalFeedback',
            'totalAnswers',
            'templatePct',
            'aiPct',
            'likePct',
            'dislikePct',
            'templateCount',
            'aiCount',
            'ticketEscalations',
            'dislikeCount',
            'pendingDislikeCount',
            'pendinglikeCount',
            'pendingLikeCount',
            'adminRedirects',
            'dailyLabels',
            'dailyValues',
            'monthlyLabels',
            'monthlyValues',
            'topQuestions',
            'evaluationLogs',
            'unansweredQuestions',
            'recentAiLogs',
            'aiRequestsToday',
            'aiRequestsThisMonth',
            'geminiDailyLimit',
            'geminiUsagePercent',
            'activeApiKey',
            'activeKeyName',
            'maskedApiKey',
            'savedApiKeys',
            'activeModel',
            'quotaStatus',
            'quotaStatusText'
        ));
    }

    /**
     * Store a new API Key into saved keys pool and optionally activate it.
     */
    public function updateApiKey(Request $request): JsonResponse
    {
        $request->validate([
            'api_key' => 'required|string|min:15',
            'name' => 'nullable|string|max:100',
            'set_active' => 'nullable|boolean',
        ]);

        $newKey = trim($request->input('api_key'));
        $name = trim($request->input('name')) ?: ('Kunci Cadangan #' . (FaqApiKey::count() + 1));
        $setActive = $request->boolean('set_active', true);

        // Verification ping to Google Gemini API using modern supported models
        $candidateModels = ['gemini-3.5-flash', 'gemini-3.1-flash-lite', 'gemini-flash-latest'];
        $verifiedModel = null;
        $lastError = '';

        foreach ($candidateModels as $candidate) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$candidate}:generateContent?key={$newKey}";
            $payload = json_encode([
                'contents' => [
                    ['parts' => [['text' => 'ping']]]
                ]
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 12);

            // Optional Squid Forward Proxy
            $proxy = config('services.gemini.proxy') 
                ?: env('GEMINI_PROXY') 
                ?: env('https_proxy') 
                ?: env('HTTPS_PROXY') 
                ?: env('http_proxy') 
                ?: env('HTTP_PROXY');
            if (!empty($proxy)) {
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            }

            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlErr = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200) {
                $verifiedModel = $candidate;
                break;
            } else {
                $errorData = json_decode($res, true);
                $lastError = $errorData['error']['message'] ?? ($curlErr ?: "Kode HTTP {$httpCode}");
            }
        }

        if (!$verifiedModel) {
            return response()->json([
                'success' => false,
                'message' => "Verifikasi API Key gagal: {$lastError}",
            ], 422);
        }

        $model = $verifiedModel;

        // Deactivate others if this key is set to active
        if ($setActive) {
            FaqApiKey::query()->update(['is_active' => false]);
        }

        // Save into faq_api_keys table
        $savedKey = FaqApiKey::create([
            'name' => $name,
            'api_key' => $newKey,
            'is_active' => $setActive,
            'daily_limit' => 1500,
            'model' => $model,
        ]);

        // If active, update .env file as well
        if ($setActive) {
            $this->updateEnvFile([
                'GEMINI_API_KEY' => $newKey,
                'GEMINI_MODEL' => $model,
                'GEMINI_DAILY_LIMIT' => 1500,
            ]);

            try {
                Artisan::call('config:clear');
            } catch (\Throwable $e) {
                Log::warning('Config clear error after updating API key: ' . $e->getMessage());
            }
        }

        $allKeys = FaqApiKey::orderByDesc('is_active')->latest()->get()->map(function ($k) {
            return [
                'id' => $k->id,
                'name' => $k->name,
                'masked_key' => $k->masked_key,
                'is_active' => $k->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => "API Key '{$name}' berhasil diverifikasi dan disimpan" . ($setActive ? " serta diaktifkan!" : "!"),
            'masked_key' => substr($newKey, 0, 8) . '••••••••••••' . substr($newKey, -4),
            'active_name' => $name,
            'saved_keys' => $allKeys,
        ]);
    }

    /**
     * Switch active API Key from saved keys list.
     */
    public function switchApiKey(Request $request): JsonResponse
    {
        $request->validate([
            'key_id' => 'required|exists:faq_api_keys,id',
        ]);

        $key = FaqApiKey::findOrFail($request->input('key_id'));

        // Set all to inactive, activate selected
        FaqApiKey::query()->update(['is_active' => false]);
        $key->update(['is_active' => true]);

        // Sync to .env
        $this->updateEnvFile([
            'GEMINI_API_KEY' => $key->api_key,
            'GEMINI_DAILY_LIMIT' => 1500,
            'GEMINI_MODEL' => $key->model ?: 'gemini-3.5-flash',
        ]);

        try {
            Artisan::call('config:clear');
        } catch (\Throwable $e) {
            Log::warning('Config clear error after switching API key: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => "Kunci API berhasil dialihkan ke '{$key->name}'!",
            'name' => $key->name,
            'masked_key' => $key->masked_key,
        ]);
    }

    /**
     * Delete an API Key from saved collection.
     */
    public function deleteApiKey($id): JsonResponse
    {
        $key = FaqApiKey::findOrFail($id);
        $keyName = $key->name;
        $wasActive = (bool) $key->is_active;

        // Lepas relasi log chat jika ada
        FaqChatLog::where('api_key_id', $id)->update(['api_key_id' => null]);

        $key->delete();

        // Jika kunci yang dihapus adalah kunci aktif, alihkan ke kunci lain jika masih ada
        if ($wasActive) {
            $nextKey = FaqApiKey::latest()->first();
            if ($nextKey) {
                $nextKey->update(['is_active' => true]);
                $this->updateEnvFile([
                    'GEMINI_API_KEY' => $nextKey->api_key,
                    'GEMINI_MODEL' => $nextKey->model ?: 'gemini-1.5-flash',
                ]);
            } else {
                $this->updateEnvFile([
                    'GEMINI_API_KEY' => '',
                ]);
            }

            try {
                Artisan::call('config:clear');
            } catch (\Throwable $e) {
                Log::warning('Config clear error after deleting active API key: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Kunci API '{$keyName}' berhasil dihapus." . ($wasActive ? ' Sistem dialihkan ke kunci cadangan.' : ''),
            'was_active' => $wasActive,
        ]);
    }

    /**
     * Test / Verify quota status of any saved API key without switching to it.
     */
    public function testApiKey(Request $request): JsonResponse
    {
        $request->validate([
            'key_id' => 'required|exists:faq_api_keys,id',
        ]);

        $key = FaqApiKey::findOrFail($request->input('key_id'));
        $testKey = $key->api_key;
        $candidateModels = [$key->model ?: 'gemini-3.5-flash', 'gemini-3.1-flash-lite', 'gemini-flash-latest'];

        $verified = false;
        $statusMessage = '';
        $isQuotaLimit = false;

        foreach ($candidateModels as $candidate) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$candidate}:generateContent?key={$testKey}";
            $payload = json_encode([
                'contents' => [
                    ['parts' => [['text' => 'ping']]]
                ]
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            // Optional Squid Forward Proxy
            $proxy = config('services.gemini.proxy') 
                ?: env('GEMINI_PROXY') 
                ?: env('https_proxy') 
                ?: env('HTTPS_PROXY') 
                ?: env('http_proxy') 
                ?: env('HTTP_PROXY');
            if (!empty($proxy)) {
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            }

            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlErr = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200) {
                $verified = true;
                $statusMessage = "Kunci '{$key->name}' aktif normal dan kuota panggilan Gemini tersedia!";
                break;
            } elseif ($httpCode === 429) {
                $isQuotaLimit = true;
                $statusMessage = "Google Gemini API: Batas kuota harian (Resource Exhausted 429) pada kunci ini telah tercapai!";
                break;
            } else {
                $errorData = json_decode($res, true);
                $statusMessage = $errorData['error']['message'] ?? ($curlErr ?: "Kode HTTP {$httpCode}");
            }
        }

        return response()->json([
            'success' => $verified,
            'is_limit' => $isQuotaLimit,
            'message' => $statusMessage,
            'key_name' => $key->name,
            'masked_key' => $key->masked_key,
        ]);
    }

    /**
     * Mark an evaluation question log as reviewed.
     */
    public function markReviewed($id): JsonResponse
    {
        $log = FaqChatLog::findOrFail($id);
        $log->update([
            'is_reviewed' => true,
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan telah ditandai selesai ditinjau.',
        ]);
    }

    /**
     * Update or append environment variables in .env file (safely handles read-only .env).
     */
    protected function updateEnvFile(array $data): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath) || !is_writable($envPath)) {
            // Jika .env tidak dapat ditulis (standar permission server Linux),
            // abaikan secara aman karena API Key aktif sudah tersimpan di tabel faq_api_keys
            return;
        }

        try {
            $envContent = file_get_contents($envPath);

            foreach ($data as $key => $value) {
                if (preg_match("/^{$key}=.*/m", $envContent)) {
                    $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
                } else {
                    $envContent .= "\n{$key}={$value}";
                }
            }

            @file_put_contents($envPath, $envContent);
        } catch (\Throwable $e) {
            Log::warning('Gagal memperbarui file .env: ' . $e->getMessage());
        }
    }
}
