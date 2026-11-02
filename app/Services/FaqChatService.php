<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\FaqChatLog;
use App\Models\FaqUnansweredQuestion;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FaqChatService
{
    protected Client $httpClient;

    /**
     * Fallback candidate models for Gemini API (ordered by preference)
     */
    protected array $geminiModels = [
        'gemini-3.5-flash',
        'gemini-3.1-flash-lite',
        'gemini-3.5-flash-lite',
        'gemini-flash-latest',
    ];

    public function __construct()
    {
        $this->httpClient = new Client([
            'timeout' => 20,
            'connect_timeout' => 6,
        ]);
    }

    /**
     * Normalize text: lowercase and strip non-alphanumeric characters.
     */
    public function cleanText(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[-_]/', ' ', $text);
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    /**
     * Split text into array of clean lowercase words.
     */
    public function tokenize(string $text): array
    {
        $cleaned = $this->cleanText($text);
        if ($cleaned === '') {
            return [];
        }
        return explode(' ', $cleaned);
    }

    /**
     * Indonesian stopwords list to filter out common conversational glue words.
     */
    protected function getStopwords(): array
    {
        return [
            'yang' => true, 'yg' => true, 'di' => true, 'ke' => true, 'dari' => true,
            'dan' => true, 'atau' => true, 'ini' => true, 'itu' => true, 'dengan' => true,
            'adalah' => true, 'yaitu' => true, 'saya' => true, 'kami' => true, 'anda' => true,
            'kamu' => true, 'dia' => true, 'mereka' => true, 'ada' => true, 'bisa' => true,
            'buat' => true, 'cara' => true, 'bagaimana' => true, 'kenapa' => true, 'mengapa' => true,
            'apakah' => true, 'tolong' => true, 'mohon' => true, 'kak' => true, 'min' => true,
            'apa' => true, 'terus' => true, 'lalu' => true, 'bagaimanakah' => true, 'harus' => true,
            'dilakukan' => true, 'kalo' => true, 'kalau' => true, 'pada' => true, 'untuk' => true,
        ];
    }

    /**
     * Calculate similarity score (0 to 100) between query and FAQ item.
     * Uses strict token overlap on non-stopword subjects to prevent false matches.
     */
    public function calculateScore(string $query, Faq $faq): int
    {
        $cleanedQuery = $this->cleanText($query);
        $cleanedQuestion = $this->cleanText($faq->question);

        if ($cleanedQuery === $cleanedQuestion) {
            return 100;
        }

        if ($cleanedQuery === '' || $cleanedQuestion === '') {
            return 0;
        }

        // Exact substring with reasonable length
        if (str_contains($cleanedQuestion, $cleanedQuery) && mb_strlen($cleanedQuery) >= 12) {
            return 95;
        }

        $stopwords = $this->getStopwords();

        // Extract key subject words (excluding stopwords and words <= 2 chars)
        $queryTokens = array_values(array_filter(
            $this->tokenize($cleanedQuery),
            fn($w) => !isset($stopwords[$w]) && mb_strlen($w) > 2
        ));

        $questionTokens = array_values(array_filter(
            $this->tokenize($cleanedQuestion),
            fn($w) => !isset($stopwords[$w]) && mb_strlen($w) > 2
        ));

        if (empty($queryTokens) || empty($questionTokens)) {
            return 0;
        }

        // Count how many subject words match
        $matchedTokens = 0;
        foreach ($queryTokens as $qw) {
            foreach ($questionTokens as $qtw) {
                if ($qw === $qtw) {
                    $matchedTokens++;
                    break;
                }
            }
        }

        $matchRatio = $matchedTokens / max(count($queryTokens), count($questionTokens));

        // Keywords check (strict)
        $keywordBonus = 0;
        if (!empty($faq->keywords)) {
            $keywords = array_filter(array_map('trim', explode(',', mb_strtolower($faq->keywords))));
            $kwMatches = 0;
            foreach ($queryTokens as $qw) {
                if (in_array($qw, $keywords, true)) {
                    $kwMatches++;
                }
            }
            if ($kwMatches >= 2) {
                $keywordBonus = 15;
            }
        }

        $finalScore = (int) round(($matchRatio * 85) + $keywordBonus);
        return min(100, $finalScore);
    }

    /**
     * Process user query:
     * 1. If explicit $faqId is provided (user clicked a template), directly return that template.
     * 2. If user typed a message:
     *    - Check if it strictly matches a FAQ template (score >= 90).
     *    - Otherwise, engage Google Gemini AI with multi-turn conversation history.
     */
    public function askQuestion(?int $userId, string $sessionId, string $message, ?int $faqId = null): array
    {
        $message = trim($message);

        // ==================== 1. EXPLICIT TEMPLATE CLICK ====================
        if ($faqId !== null) {
            $faq = Faq::where('is_active', true)->find($faqId);
            if ($faq) {
                $displayedQ = !empty($message) ? $message : $faq->question;

                // Log turn so follow-up questions can reference this template in AI history!
                FaqChatLog::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'question' => $displayedQ,
                    'faq_id' => $faq->id,
                    'source' => 'template',
                    'ai_response' => null,
                    'confidence_score' => 100,
                    'is_answer_found' => true,
                    'created_at' => now(),
                ]);

                return [
                    'found' => true,
                    'source' => 'template',
                    'message' => $faq->answer,
                    'faq' => [
                        'id' => $faq->id,
                        'question' => $faq->question,
                        'category' => $faq->category,
                    ],
                    'suggestions' => $this->getRelatedSuggestions($faq->id, $faq->category),
                    'confidence' => 100,
                    'session_id' => $sessionId,
                    'is_multi_turn' => false,
                ];
            }
        }

        if ($message === '') {
            return [
                'found' => false,
                'source' => 'template',
                'message' => 'Pertanyaan tidak boleh kosong.',
                'faq' => null,
                'suggestions' => [],
                'confidence' => 0,
                'session_id' => $sessionId,
                'is_multi_turn' => false,
            ];
        }

        $lowerMsg = mb_strtolower($message);

        // Escalation check
        if (
            $lowerMsg === 'admin' || $lowerMsg === 'cs' || $lowerMsg === 'operator' ||
            str_contains($lowerMsg, 'panggil admin') || str_contains($lowerMsg, 'hubungi admin') ||
            str_contains($lowerMsg, 'chat admin') || str_contains($lowerMsg, 'bicara dengan admin') ||
            str_contains($lowerMsg, 'hubungi cs') || str_contains($lowerMsg, 'customer service')
        ) {
            $this->trackEscalation($sessionId, 'contact_admin');
            return [
                'found' => false,
                'source' => 'escalation',
                'message' => "Tentu kak, silakan hubungi Customer Support resmi kami atau buat tiket pengaduan di bawah ini agar petugas teknis kami dapat membantu kendala Anda secara langsung.",
                'faq' => null,
                'suggestions' => [],
                'confidence' => 0,
                'session_id' => $sessionId,
                'show_escalation' => true,
                'is_multi_turn' => false,
            ];
        }

        // ==================== 2. STRICT TEMPLATE SEARCH ====================
        $activeFaqs = Faq::where('is_active', true)->get();
        $bestFaq = null;
        $highestScore = 0;
        $suggestions = [];

        foreach ($activeFaqs as $faq) {
            $score = $this->calculateScore($message, $faq);
            if ($score >= 90) {
                if ($score > $highestScore) {
                    $highestScore = $score;
                    $bestFaq = $faq;
                }
            } elseif ($score >= 45) {
                $suggestions[] = [
                    'id' => $faq->id,
                    'question' => $faq->question,
                    'category' => $faq->category,
                    'score' => $score,
                ];
            }
        }

        // If an exact/very high confidence template is found, serve it directly
        if ($bestFaq !== null && $highestScore >= 90) {
            FaqChatLog::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'question' => $message,
                'faq_id' => $bestFaq->id,
                'source' => 'template',
                'ai_response' => null,
                'confidence_score' => $highestScore,
                'is_answer_found' => true,
                'created_at' => now(),
            ]);

            return [
                'found' => true,
                'source' => 'template',
                'message' => $bestFaq->answer,
                'faq' => [
                    'id' => $bestFaq->id,
                    'question' => $bestFaq->question,
                    'category' => $bestFaq->category,
                ],
                'suggestions' => array_slice($suggestions, 0, 3),
                'confidence' => $highestScore,
                'session_id' => $sessionId,
                'is_multi_turn' => false,
            ];
        }

        // ==================== 3. MULTI-TURN AI CHAT WITH GEMINI ====================
        // Only save relevant Dukcapil/SIAK questions to the unanswered queue for template creation
        // (Filters out test keystrokes, spam, greetings, and random filler talk)
        $unanswered = null;
        if ($this->isRelevantDukcapilQuestion($message)) {
            $unanswered = FaqUnansweredQuestion::where('question', $message)->first();
            if ($unanswered) {
                $unanswered->increment('occurrence_count');
            } else {
                $unanswered = FaqUnansweredQuestion::create([
                    'question' => $message,
                    'occurrence_count' => 1,
                    'status' => 'pending',
                ]);
            }
        }

        // Fetch past conversation history for this session (up to 8 recent turns)
        $historyLogs = FaqChatLog::where('session_id', $sessionId)
            ->whereNotNull('question')
            ->orderBy('id', 'asc')
            ->take(8)
            ->get();

        $conversationTurns = [];
        foreach ($historyLogs as $log) {
            $botText = $log->faq ? $log->faq->answer : $log->ai_response;
            if (!empty($log->question) && !empty($botText)) {
                // Strip legacy footnotes or disclaimers from history
                $botText = preg_replace('/\s*\*?\s*\(\s*💡[^\)]*\)\.?\s*\*?/u', '', $botText);
                $botText = trim($botText);

                $conversationTurns[] = [
                    'role' => 'user',
                    'parts' => [['text' => $log->question]],
                ];
                $conversationTurns[] = [
                    'role' => 'model',
                    'parts' => [['text' => mb_substr($botText, 0, 1500)]],
                ];
            }
        }

        // Query Gemini AI with continuous multi-turn history
        $aiResult = $this->queryGeminiMultiTurn($conversationTurns, $message);

        if (!empty($aiResult['text']) && $unanswered) {
            $unanswered->update(['ai_draft_answer' => $aiResult['text']]);
        }

        $activeKeyId = \App\Models\FaqApiKey::where('is_active', true)->value('id');

        // Log this AI conversation turn
        FaqChatLog::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'question' => $message,
            'faq_id' => null,
            'api_key_id' => $activeKeyId,
            'source' => $aiResult['success'] ? 'ai_search' : 'template',
            'ai_response' => $aiResult['text'],
            'confidence_score' => $aiResult['success'] ? 90 : 0,
            'is_answer_found' => $aiResult['success'],
            'created_at' => now(),
        ]);

        return [
            'found' => $aiResult['success'],
            'source' => 'ai_search',
            'message' => $aiResult['text'],
            'faq' => null,
            'suggestions' => array_slice($suggestions, 0, 3),
            'confidence' => $aiResult['success'] ? 90 : 0,
            'session_id' => $sessionId,
            'show_escalation' => true,
            'is_multi_turn' => count($conversationTurns) > 0,
        ];
    }

    /**
     * Query Google Gemini API with continuous multi-turn context and model fallback.
     */
    protected function queryGeminiMultiTurn(array $conversationHistory, string $currentQuestion): array
    {
        $apiKey = \App\Models\FaqApiKey::where('is_active', true)->value('api_key') 
            ?: config('services.gemini.api_key', env('GEMINI_API_KEY'));

        if (empty($apiKey)) {
            return [
                'success' => false,
                'text' => "Maaf kak, saya belum menemukan jawaban yang tepat di daftar FAQ resmi kami. Pertanyaan Anda telah otomatis tersimpan untuk ditinjau oleh tim kami. Silakan klik Buat Tiket di bawah agar petugas teknis dapat segera membantu kendala Anda.",
            ];
        }

        $systemInstruction = "Anda adalah Asisten Virtual Cerdas & Helpdesk Resmi Pelayanan SIAK & Kependudukan Dukcapil Kemendagri RI.\n" .
            "Tugas Anda: Memberikan bantuan komprehensif terkait permasalahan aplikasi SIAK Terpusat, aktivasi Identitas Kependudukan Digital (IKD), kendala jaringan/VPN/timeout, perangkat keras (printer KTP-el, ribbon, card feeder), serta tata cara pengurusan dokumen kependudukan (KTP-el, Kartu Keluarga, Akta Kelahiran/Kematian, mutasi KK, pindah domisili, dan lokasi kantor pelayanan Dukcapil).\n\n" .
            "PEDOMAN MENJAWAB (SANGAT PENTING):\n" .
            "1. JAWAB LENGKAP, DETAIL, DAN TUNTAS: Jangan pernah memotong jawaban di tengah jalan atau meringkas terlalu pendek. Uraikan instruksi langkah demi langkah (1, 2, 3), persyaratan berkas yang harus disiapkan, alamat lengkap kantor pelayanan dan jam operasional jika ditanyakan, serta tips teknis terkait.\n" .
            "2. FORMAT RAPI: Gunakan poin-poin/penomoran terstruktur dan tebalkan istilah atau kata kunci penting (**kata**) agar rapi, profesional, dan sangat mudah dipahami.\n" .
            "3. INTERAKTIF & BERKELANJUTAN: Ingat konteks riwayat percakapan sebelumnya. Jika pengguna bertanya hal lanjutan (seperti 'lokasinya di mana?', 'syaratnya apa?', atau 'terus gimana?'), jawab secara langsung mengaitkan dengan konteks sebelumnya.\n" .
            "4. TIDAK PERLU DISCLAIMER: JANGAN menyertakan catatan kaki atau teks penutup seperti 'Dijawab otomatis oleh AI Assistant' atau 'Jika kendala berlanjut silakan buat tiket'. Berikan solusi langsung, ramah, dan solutif.";

        // Construct full contents array: past turns + current question
        $contents = $conversationHistory;
        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $currentQuestion]
            ]
        ];

        $payload = [
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemInstruction]
                ]
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 4000,
            ],
        ];

        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Iterate through fallback models using native PHP cURL (fully compatible with web servers)
        foreach ($this->geminiModels as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8']);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 18);

            // Optional Squid Forward Proxy for isolated production servers
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

            $output = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200 && !empty($output)) {
                $data = json_decode($output, true);
                $aiText = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if (!empty($aiText)) {
                    return [
                        'success' => true,
                        'text' => trim($aiText),
                    ];
                }
            }

            Log::info("Gemini model {$model} returned HTTP {$httpCode} ({$curlError}). Trying next model...");
        }

        // Fallback message if all models hit rate limit
        return [
            'success' => false,
            'text' => "Maaf kak, layanan AI sedang menerima volume pertanyaan yang sangat tinggi saat ini. Pertanyaan Anda sudah otomatis kami catat ke sistem pemantauan admin. Anda dapat langsung membuat tiket pengaduan di tombol bawah agar petugas teknis kami segera menangani kendala Anda.",
        ];
    }

    /**
     * Get related FAQ suggestions for a category.
     */
    protected function getRelatedSuggestions(int $excludeId, ?string $category): array
    {
        return Faq::where('is_active', true)
            ->where('id', '!=', $excludeId)
            ->when($category, fn($q) => $q->where('category', $category))
            ->take(3)
            ->get(['id', 'question', 'category'])
            ->toArray();
    }

    /**
     * Record feedback status (helped or not_helped) for a chat session.
     */
    public function updateFeedback(string $sessionId, ?int $faqId, string $status): bool
    {
        $log = FaqChatLog::where('session_id', $sessionId)
            ->when($faqId, fn($q) => $q->where('faq_id', $faqId))
            ->latest('id')
            ->first();

        if ($log) {
            $log->update([
                'feedback_status' => $status,
                'is_answer_found' => ($status === 'helped'),
            ]);
            return true;
        }

        FaqChatLog::create([
            'session_id' => $sessionId,
            'question' => 'feedback:' . $status,
            'faq_id' => $faqId,
            'source' => 'template',
            'confidence_score' => 100,
            'is_answer_found' => ($status === 'helped'),
            'feedback_status' => $status,
            'created_at' => now(),
        ]);

        return true;
    }

    /**
     * Record user escalation action (create_ticket or contact_admin).
     */
    public function trackEscalation(string $sessionId, string $action): bool
    {
        $log = FaqChatLog::where('session_id', $sessionId)->latest('id')->first();
        if ($log) {
            $log->update(['escalation_action' => $action]);
            return true;
        }

        FaqChatLog::create([
            'session_id' => $sessionId,
            'question' => 'action:' . $action,
            'escalation_action' => $action,
            'confidence_score' => 0,
            'is_answer_found' => false,
            'created_at' => now(),
        ]);

        return true;
    }

    /**
     * Determine if a user question is relevant to Dukcapil, SIAK, or technical helpdesk,
     * and suitable to be captured as a candidate for a new FAQ template.
     */
    public function isRelevantDukcapilQuestion(string $message): bool
    {
        $clean = mb_strtolower(trim($message), 'UTF-8');
        
        // 1. Minimum character threshold (at least 3 characters)
        if (mb_strlen($clean) < 3) {
            return false;
        }

        // 2. Blacklist greeting, test, single filler words or small talk
        $exactBlacklist = [
            'tes', 'test', 'testing', 'coba', 'halo', 'hai', 'p', 'ping', 'hei', 'hey',
            'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam',
            'ok', 'oke', 'siap', 'makasih', 'terima kasih', 'thanks', 'thank you',
            'asdf', 'qwerty', '12345', 'apa kabar', 'siapa kamu', 'kamu siapa'
        ];
        if (in_array($clean, $exactBlacklist, true)) {
            return false;
        }

        // Capture all legitimate inquiries
        return true;
    }
}
