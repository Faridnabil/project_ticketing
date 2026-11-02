<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqChatLog;
use App\Services\FaqChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FaqChatController extends Controller
{
    protected FaqChatService $faqService;

    public function __construct(FaqChatService $faqService)
    {
        $this->faqService = $faqService;
    }

    /**
     * Display the interactive FAQ Chat Assistant page with categorized templates.
     */
    public function index()
    {
        $allFaqs = Faq::where('is_active', true)
            ->orderBy('category')
            ->orderBy('question')
            ->get();

        $categories = $allFaqs->groupBy('category');
        $popularFaqs = $allFaqs->take(5);

        return view('dashboard.faq.chat', compact('categories', 'popularFaqs', 'allFaqs'));
    }

    /**
     * Retrieve conversation history for active session or logged-in user.
     */
    public function history(Request $request): JsonResponse
    {
        $sessionId = $request->query('session_id');
        $userId = Auth::id();

        if (empty($sessionId) && $userId) {
            $latestLog = FaqChatLog::where('user_id', $userId)
                ->where('created_at', '>=', now()->subHours(24))
                ->latest('id')
                ->first();
            if ($latestLog) {
                $sessionId = $latestLog->session_id;
            }
        }

        if (empty($sessionId)) {
            return response()->json([
                'success' => true,
                'session_id' => 'sess_' . Str::random(10) . '_' . time(),
                'messages' => [],
            ]);
        }

        $logs = FaqChatLog::with('faq')
            ->where('session_id', $sessionId)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->orderBy('id', 'asc')
            ->get();

        $history = [];
        foreach ($logs as $log) {
            if (!empty($log->question)) {
                $history[] = [
                    'role' => 'user',
                    'message' => $log->question,
                    'time' => $log->created_at ? $log->created_at->format('H:i') : null,
                ];
            }

            $botAnswer = $log->faq ? $log->faq->answer : $log->ai_response;
            if (!empty($botAnswer)) {
                $history[] = [
                    'role' => 'bot',
                    'source' => $log->source,
                    'message' => $botAnswer,
                    'faq' => $log->faq ? [
                        'id' => $log->faq->id,
                        'question' => $log->faq->question,
                        'category' => $log->faq->category,
                    ] : null,
                    'feedback_status' => $log->feedback_status,
                    'is_multi_turn' => true,
                    'time' => $log->created_at ? $log->created_at->format('H:i') : null,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'session_id' => $sessionId,
            'messages' => $history,
        ]);
    }

    /**
     * Handle chat question or template selection from user.
     */
    public function ask(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'nullable|string',
            'faq_id' => 'nullable|integer',
            'session_id' => 'nullable|string',
        ]);

        $sessionId = $request->input('session_id') ?: (string) Str::uuid();
        $userId = Auth::id();
        $faqId = $request->input('faq_id') ? (int) $request->input('faq_id') : null;
        $message = (string) $request->input('message', '');

        $result = $this->faqService->askQuestion($userId, $sessionId, $message, $faqId);

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * Submit feedback (helped or not_helped) for a question.
     */
    public function feedback(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'status' => 'required|in:helped,not_helped',
            'faq_id' => 'nullable|integer',
        ]);

        $this->faqService->updateFeedback(
            $request->input('session_id'),
            $request->input('faq_id'),
            $request->input('status')
        );

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas umpan balik Anda!',
        ]);
    }

    /**
     * Track user escalation action (create_ticket or contact_admin).
     */
    public function action(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'action' => 'required|in:create_ticket,contact_admin',
        ]);

        $this->faqService->trackEscalation(
            $request->input('session_id'),
            $request->input('action')
        );

        return response()->json([
            'success' => true,
            'message' => 'Aktivitas berhasil dicatat',
        ]);
    }

    /**
     * Reset chat session for interactive conversation.
     */
    public function reset(Request $request): JsonResponse
    {
        $newSessionId = 'sess_' . Str::random(10) . '_' . time();
        return response()->json([
            'success' => true,
            'session_id' => $newSessionId,
            'message' => 'Sesi percakapan baru berhasil dibuat.',
        ]);
    }

    /**
     * Get popular active FAQs for sidebar or chip suggestions.
     */
    public function popular(): JsonResponse
    {
        $faqs = Faq::where('is_active', true)->latest()->take(5)->get();
        return response()->json([
            'success' => true,
            'data' => $faqs,
        ]);
    }

    /**
     * Get detail of a specific FAQ item.
     */
    public function show(int $id): JsonResponse
    {
        $faq = Faq::where('is_active', true)->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $faq,
        ]);
    }
}
