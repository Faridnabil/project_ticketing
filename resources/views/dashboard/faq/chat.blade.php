@extends('layouts.dashboard.app')

@section('title')
    FAQ Chat Assistant | SIAK Dukcapil
@endsection

@section('content')
<style>
    /* Strict chat layout containment & custom scrollbar */
    .faq-chat-page-card {
        height: calc(100vh - 195px);
        min-height: 560px;
        max-height: calc(100vh - 195px);
        overflow: hidden !important;
        display: flex;
        flex-direction: column;
    }
    @media (max-width: 991.98px) {
        .faq-chat-page-card {
            height: auto;
            max-height: none;
            min-height: 520px;
        }
    }
    #fullChatMessages {
        flex: 1 1 0px !important;
        min-height: 0 !important;
        max-height: 100% !important;
        overflow-y: auto !important;
        scroll-behavior: smooth;
    }
    #faqAccordionContainer {
        flex: 1 1 0px !important;
        min-height: 0 !important;
        overflow-y: auto !important;
    }
    .chat-scroll-custom::-webkit-scrollbar {
        width: 6px;
    }
    .chat-scroll-custom::-webkit-scrollbar-track {
        background: transparent;
    }
    .chat-scroll-custom::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 4px;
    }
    .chat-scroll-custom::-webkit-scrollbar-thumb:hover {
        background: #94A3B8;
    }
    #fullChatSubmitBtn {
        transition: transform 0.2s ease, background-color 0.2s ease;
    }
    #fullChatSubmitBtn:hover {
        background-color: #003366 !important;
        transform: scale(1.06);
    }
    #fullChatSubmitBtn:active {
        transform: scale(0.96);
    }
</style>

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">FAQ Chat Assistant
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Asisten Interaktif & Penjawab Otomatis</small>
            </h1>
        </div>

    </div>
</div>
<!--end::Toolbar-->

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-6">
            <!--begin::Left Sidebar: Template Catalog by Category-->
            <div class="col-lg-4 col-xl-4">
                <div class="card card-flush shadow-sm faq-chat-page-card">
                    <!--Header-->
                    <div class="card-header py-4 shrink-0" style="background: linear-gradient(135deg, #002147 0%, #003366 100%) !important; flex-shrink: 0;">
                        <div class="card-title text-white flex-column align-items-start">
                            <span class="fw-bolder fs-5 text-white d-flex align-items-center gap-2">
                                <i class="bi bi-journal-bookmark-fill text-warning fs-4"></i> Katalog Solusi & FAQ
                            </span>
                            <span class="text-white-50 fs-8 mt-1">Pilih kategori atau template solusi terverifikasi</span>
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column flex-grow-1 overflow-hidden" style="flex: 1 1 0px; min-height: 0;">
                        <div class="d-flex flex-column h-100 overflow-hidden" style="flex: 1 1 0px; min-height: 0;">
                            <!--Search Template Input-->
                            <div class="position-relative mb-3 shrink-0" style="flex-shrink: 0;">
                                <span class="svg-icon svg-icon-3 position-absolute top-50 translate-middle-y ms-3">
                                    <i class="bi bi-search text-gray-500"></i>
                                </span>
                                <input type="text" id="faqCatalogSearch" class="form-control form-control-sm form-control-solid ps-9 fs-7" placeholder="Cari template pertanyaan..." autocomplete="off">
                            </div>

                            <!--Category Filter Pills (Clean, wrapped buttons)-->
                            <div class="d-flex flex-wrap gap-2 mb-3 shrink-0" style="flex-shrink: 0;">
                                <button type="button" class="btn btn-sm btn-primary fw-bold category-filter-btn px-3 py-1 fs-8 active" data-category="all">
                                    Semua
                                </button>
                                @foreach($categories as $catName => $catItems)
                                    <button type="button" class="btn btn-sm btn-light-primary text-gray-800 fw-bold category-filter-btn px-3 py-1 fs-8" data-category="{{ Str::slug($catName) }}">
                                        {{ $catName }} <span class="badge badge-light-primary ms-1 fs-9">{{ count($catItems) }}</span>
                                    </button>
                                @endforeach
                            </div>

                            <!--Grouped Questions List with Clean Cards-->
                            <div class="pe-1 chat-scroll-custom" id="faqAccordionContainer" style="flex: 1 1 0px !important; min-height: 0 !important; overflow-y: auto !important;">
                                @forelse($categories as $catName => $catItems)
                                    <div class="category-block mb-3" data-category-slug="{{ Str::slug($catName) }}">
                                        <div class="d-flex align-items-center justify-content-between text-muted fw-bolder fs-8 text-uppercase py-1 px-2 bg-light rounded mb-2">
                                            <span><i class="bi bi-folder2-open text-primary me-1"></i> {{ $catName }}</span>
                                            <span class="badge badge-light-secondary fs-9">{{ count($catItems) }}</span>
                                        </div>
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($catItems as $item)
                                                <button type="button" 
                                                    class="btn btn-sm btn-light text-start p-2 rounded-2 text-dark fs-7 hover-elevate-up d-flex align-items-center justify-content-between border border-dashed border-gray-300 faq-item-btn" 
                                                    data-search-text="{{ strtolower($item->question . ' ' . $item->keywords) }}"
                                                    onclick="selectFaqTemplate({{ $item->id }}, '{{ addslashes($item->question) }}')">
                                                    <span class="text-truncate pe-2 text-gray-800 fw-semibold">{{ $item->question }}</span>
                                                    <i class="bi bi-arrow-right-short fs-4 text-primary shrink-0"></i>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-muted fs-7">Belum ada template FAQ aktif.</div>
                                @endforelse
                            </div>
                        </div>

                        <!--Bottom Clean Reset Action-->
                        <div class="mt-3 pt-3 border-top shrink-0" style="flex-shrink: 0;">
                            <button type="button" class="btn btn-sm btn-light-danger w-100 fw-bold fs-7 py-2" id="resetFullChatBtn">
                                <i class="bi bi-arrow-clockwise me-1"></i> Mulai Obrolan Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Left Sidebar-->

            <!--begin::Right: Interactive Chat Window-->
            <div class="col-lg-8 col-xl-8">
                <div class="card card-flush shadow-sm faq-chat-page-card">
                    <!--Header-->
                    <div class="card-header border-bottom py-3 px-6 d-flex align-items-center justify-content-between bg-light shrink-0" style="flex-shrink: 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-40px symbol-circle d-flex align-items-center justify-content-center" style="background-color: #002147 !important;">
                                <i class="bi bi-robot fs-3" style="color: #C5A059;"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bolder fs-5 text-dark">Asisten Dukcapil</span>
                                    <span class="badge badge-light-success fs-9 fw-bold">Interaktif</span>
                                </div>
                                <div class="d-flex align-items-center text-success fs-8 fw-semibold">
                                    <span style="display:inline-block; width:7px; height:7px; background-color:#50CD89; border-radius:50%; margin-right:5px; box-shadow: 0 0 6px rgba(80, 205, 137, 0.8);"></span> Online & Siap Menjawab
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('ticket.create.redirect') }}" class="btn btn-sm btn-danger fw-bold fs-8">
                                <i class="bi bi-plus-circle me-1"></i> Buat Tiket Manual
                            </a>
                        </div>
                    </div>

                    <!--Messages Container-->
                    <div class="card-body p-6 d-flex flex-column gap-3 chat-scroll-custom" id="fullChatMessages" style="background: #F8FAFD; flex: 1 1 0px !important; min-height: 0 !important; max-height: 100% !important; overflow-y: auto !important;">
                        <!-- Initial Greeting Message -->
                        <div class="d-flex align-items-start gap-3 me-auto" style="max-width: 85%;">
                            <div class="symbol symbol-35px symbol-circle d-flex align-items-center justify-content-center mt-1 shrink-0" style="background: #002147;">
                                <i class="bi bi-robot fs-4" style="color: #C5A059;"></i>
                            </div>
                            <div class="p-4 rounded-4 bg-white shadow-sm border text-dark fs-6" style="border-top-left-radius: 4px !important;">
                                <div class="fw-bold mb-1 text-primary">
                                    Halo {{ Auth::user()->name ?? 'Bapak/Ibu' }}! 👋
                                </div>
                                <div class="text-gray-700 fs-7 mb-2">
                                    Ada yang bisa saya bantu terkait kendala sistem SIAK, jaringan, printer, atau layanan kependudukan hari ini?
                                </div>
                                @if($popularFaqs->count() > 0)
                                    <div class="text-muted fs-8 mb-2">
                                        Anda dapat memilih template solusi di sebelah kiri atau langsung mengetik pertanyaan Anda di bawah:
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($popularFaqs as $pop)
                                            <button type="button" class="btn btn-sm btn-light-primary py-1 px-3 rounded-pill fs-8 fw-bold" onclick="selectFaqTemplate({{ $pop->id }}, '{{ addslashes($pop->question) }}')">
                                                💡 {{ $pop->question }}
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-muted fs-8">
                                        Silakan langsung ketik pertanyaan atau kendala Anda pada kolom obrolan di bawah.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!--Chat Input Box (Clean, focused)-->
                    <div class="card-footer p-4 border-top bg-white shrink-0" style="flex-shrink: 0; position: relative; z-index: 5;">
                        <form id="fullChatForm" class="d-flex align-items-center gap-2 m-0">
                            <input type="text" id="fullChatInput" class="form-control form-control-solid rounded-pill px-5 fs-6" placeholder="Ketik pertanyaan atau pertanyaan lanjutan di sini..." autocomplete="off">
                            <button type="submit" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; background-color: #002147; border: none; padding: 0;" id="fullChatSubmitBtn" title="Kirim Pesan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#C5A059">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Right-->
        </div>
    </div>
</div>
<!--end::Post-->
@endsection

@section('scripts')
<script>
    (function() {
        const form = document.getElementById('fullChatForm');
        const input = document.getElementById('fullChatInput');
        const submitBtn = document.getElementById('fullChatSubmitBtn');
        const messages = document.getElementById('fullChatMessages');
        const resetBtn = document.getElementById('resetFullChatBtn');
        const catalogSearch = document.getElementById('faqCatalogSearch');
        const categoryBtns = document.querySelectorAll('.category-filter-btn');
        const categoryBlocks = document.querySelectorAll('.category-block');
        const faqItems = document.querySelectorAll('.faq-item-btn');

        function scrollToBottom() {
            setTimeout(() => {
                if (messages) {
                    messages.scrollTop = messages.scrollHeight;
                }
            }, 50);
        }

        // Session ID management (shared across widget and full page)
        let sessionId = localStorage.getItem('faq_chat_session_id') || localStorage.getItem('faq_full_session_id') || ('sess_' + Math.random().toString(36).substring(2) + Date.now());
        localStorage.setItem('faq_chat_session_id', sessionId);
        localStorage.setItem('faq_full_session_id', sessionId);

        // Load existing session history on page load so navigating pages or refreshing keeps conversation intact
        async function loadFullChatHistory() {
            try {
                const res = await fetch("{{ route('faq.chat.history') }}?session_id=" + encodeURIComponent(sessionId), {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await res.json();
                if (json.success && json.session_id) {
                    sessionId = json.session_id;
                    localStorage.setItem('faq_chat_session_id', sessionId);
                    localStorage.setItem('faq_full_session_id', sessionId);

                    if (json.messages && json.messages.length > 0) {
                        messages.innerHTML = ''; // Clear default initial placeholder
                        json.messages.forEach(msg => {
                            if (msg.role === 'user') {
                                appendUserBubble(msg.message);
                            } else {
                                appendBotBubble({
                                    source: msg.source,
                                    message: msg.message,
                                    faq: msg.faq,
                                    suggestions: [],
                                    show_escalation: true,
                                    is_multi_turn: true
                                });
                            }
                        });
                        scrollToBottom();
                    }
                }
            } catch (e) {}
        }
        loadFullChatHistory();

        // Filter by Category Pills
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                categoryBtns.forEach(b => {
                    b.classList.remove('active', 'btn-primary');
                    b.classList.add('btn-light-primary', 'text-gray-800');
                });
                this.classList.add('active', 'btn-primary');
                this.classList.remove('btn-light-primary', 'text-gray-800');

                const selectedCat = this.dataset.category;
                categoryBlocks.forEach(block => {
                    if (selectedCat === 'all' || block.dataset.categorySlug === selectedCat) {
                        block.style.display = 'block';
                    } else {
                        block.style.display = 'none';
                    }
                });
            });
        });

        // Filter by Search Input in Left Sidebar
        if (catalogSearch) {
            catalogSearch.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                faqItems.forEach(item => {
                    const text = item.dataset.searchText || '';
                    if (!query || text.includes(query)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // ==================== 1. SELECT TEMPLATE CLICK ====================
        window.selectFaqTemplate = async function(faqId, questionText) {
            appendUserBubble(questionText);
            showTypingIndicator("Memuat solusi resmi...");

            try {
                const res = await fetch("{{ route('faq.chat.ask') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        faq_id: faqId,
                        message: questionText,
                        session_id: sessionId
                    })
                });

                const json = await res.json();
                hideTypingIndicator();

                if (json.success && json.data) {
                    appendBotBubble(json.data);
                } else {
                    appendSystemErrorBubble("Gagal memuat template solusi.");
                }
            } catch (err) {
                hideTypingIndicator();
                appendSystemErrorBubble("Terjadi gangguan koneksi.");
            }
        };

        // ==================== 2. SUBMIT CHAT PROMPT (AI MULTI-TURN) ====================
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;

                appendUserBubble(text);
                input.value = '';
                input.disabled = true;
                if (submitBtn) submitBtn.disabled = true;
                showTypingIndicator("Sedang menganalisis pertanyaan...");

                try {
                    const res = await fetch("{{ route('faq.chat.ask') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: text,
                            session_id: sessionId
                        })
                    });

                    const json = await res.json();
                    hideTypingIndicator();

                    if (json.success && json.data) {
                        appendBotBubble(json.data);
                    } else {
                        appendSystemErrorBubble("Gagal memproses pertanyaan.");
                    }
                } catch (err) {
                    hideTypingIndicator();
                    appendSystemErrorBubble("Terjadi gangguan koneksi ke server.");
                } finally {
                    input.disabled = false;
                    if (submitBtn) submitBtn.disabled = false;
                    input.focus();
                }
            });
        }

        // ==================== 3. RESET SESSION BUTTON ====================
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                const doReset = async () => {
                    try {
                        const res = await fetch("{{ route('faq.chat.reset') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ session_id: sessionId })
                        });
                        const data = await res.json();
                        if (data.session_id) {
                            sessionId = data.session_id;
                            localStorage.setItem('faq_chat_session_id', sessionId);
                            localStorage.setItem('faq_full_session_id', sessionId);
                        }
                    } catch (e) {
                        sessionId = 'sess_' + Math.random().toString(36).substring(2) + Date.now();
                        localStorage.setItem('faq_chat_session_id', sessionId);
                        localStorage.setItem('faq_full_session_id', sessionId);
                    }

                    messages.innerHTML = `
                        <div class="d-flex align-items-start gap-3 me-auto" style="max-width: 85%;">
                            <div class="symbol symbol-35px symbol-circle d-flex align-items-center justify-content-center mt-1 shrink-0" style="background: #002147;">
                                <i class="bi bi-robot fs-4" style="color: #C5A059;"></i>
                            </div>
                            <div class="p-4 rounded-4 bg-white shadow-sm border text-dark fs-6" style="border-top-left-radius: 4px !important;">
                                <div class="fw-bold mb-1 text-primary">Obrolan Baru Dimulai 👋</div>
                                <div class="text-gray-700 fs-7">Silakan pilih topik solusi di panel kiri atau ketik kendala yang ingin Anda tanyakan di bawah ini.</div>
                            </div>
                        </div>
                    `;
                    messages.scrollTop = messages.scrollHeight;

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            text: 'Percakapan baru telah dimulai.',
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-primary btn-sm'
                            },
                            timer: 1500
                        });
                    }
                };

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Mulai Obrolan Baru?',
                        text: 'Riwayat percakapan saat ini akan dibersihkan.',
                        icon: 'question',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: '<i class="bi bi-arrow-clockwise me-1"></i> Ya, Reset Obrolan',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'btn btn-primary btn-sm fw-bold',
                            cancelButton: 'btn btn-light btn-sm fw-bold'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            doReset();
                        }
                    });
                } else {
                    if (confirm('Apakah Anda yakin ingin memulai obrolan baru?')) {
                        doReset();
                    }
                }
            });
        }

        // ==================== RENDERING FUNCTIONS ====================
        function appendUserBubble(text) {
            const userRow = document.createElement('div');
            userRow.className = 'd-flex align-items-start gap-3 ms-auto';
            userRow.style.maxWidth = '80%';
            userRow.innerHTML = `
                <div class="p-4 rounded-4 text-white shadow-sm fs-6" style="background-color: #002147 !important; border-top-right-radius: 4px !important;">
                    ${escapeHtml(text)}
                </div>
                <div class="symbol symbol-35px symbol-circle bg-light-primary text-primary d-flex align-items-center justify-content-center mt-1 shrink-0">
                    <i class="bi bi-person-fill fs-4 text-primary"></i>
                </div>
            `;
            messages.appendChild(userRow);
            scrollToBottom();
        }

        function showTypingIndicator(caption) {
            const typingRow = document.createElement('div');
            typingRow.className = 'd-flex align-items-start gap-3 me-auto';
            typingRow.id = 'fullChatTyping';
            typingRow.innerHTML = `
                <div class="symbol symbol-35px symbol-circle d-flex align-items-center justify-content-center mt-1 shrink-0" style="background: #002147;">
                    <i class="bi bi-robot fs-4" style="color: #C5A059;"></i>
                </div>
                <div class="p-3 rounded-4 bg-white shadow-sm border text-muted fs-7 fst-italic">
                    <span class="spinner-border spinner-border-sm text-primary me-2"></span>${caption || 'Sedang memproses...'}
                </div>
            `;
            messages.appendChild(typingRow);
            scrollToBottom();
        }

        function hideTypingIndicator() {
            const typingEl = document.getElementById('fullChatTyping');
            if (typingEl) typingEl.remove();
        }

        function appendBotBubble(data) {
            const botRow = document.createElement('div');
            botRow.className = 'd-flex align-items-start gap-3 me-auto';
            botRow.style.maxWidth = '85%';

            let badgeHtml = '';
            if (data.source === 'template') {
                badgeHtml = `<span class="badge badge-light-success fw-bold fs-9 mb-2"><i class="bi bi-check-circle-fill text-success me-1"></i> Template Solusi Resmi</span>`;
            } else if (data.is_multi_turn) {
                badgeHtml = `<span class="badge badge-light-warning fw-bold fs-9 mb-2" style="color: #856404; background-color: #FFF3CD;"><i class="bi bi-stars text-warning me-1"></i> Asisten Dukcapil (Lanjutan)</span>`;
            } else {
                badgeHtml = `<span class="badge badge-light-primary fw-bold fs-9 mb-2"><i class="bi bi-robot text-primary me-1"></i> Asisten Dukcapil</span>`;
            }

            // Suggestions chips
            let suggestionsHtml = '';
            if (data.suggestions && data.suggestions.length > 0) {
                suggestionsHtml = `
                    <div class="mt-3 pt-3 border-top">
                        <div class="text-muted fs-8 fw-semibold mb-2">Mungkin berkaitan:</div>
                        <div class="d-flex flex-wrap gap-2">
                            ${data.suggestions.map(s => `
                                <button type="button" class="btn btn-sm btn-light-info py-1 px-3 rounded-pill fs-8 fw-bold" onclick="selectFaqTemplate(${s.id}, '${escapeHtml(s.question)}')">
                                    📌 ${escapeHtml(s.question)}
                                </button>
                            `).join('')}
                        </div>
                    </div>
                `;
            }

            // Compact 1-line Action & Feedback Bar
            const feedbackId = 'feedback_' + Math.random().toString(36).substring(2);
            let actionBarHtml = `
                <div class="mt-3 pt-2 border-top d-flex align-items-center justify-content-between" id="${feedbackId}">
                    <div class="d-flex align-items-center gap-1">
                        <span class="text-muted fs-9">Membantu?</span>
                        <button type="button" class="btn btn-icon btn-xs btn-light-success p-1" style="width: 24px; height: 24px;" title="Membantu" onclick="submitFeedback('${feedbackId}', ${data.faq ? data.faq.id : 'null'}, 'helped')">
                            <i class="bi bi-hand-thumbs-up fs-8"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-xs btn-light-danger p-1" style="width: 24px; height: 24px;" title="Kurang Membantu" onclick="submitFeedback('${feedbackId}', ${data.faq ? data.faq.id : 'null'}, 'not_helped')">
                            <i class="bi bi-hand-thumbs-down fs-8"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('ticket.create.redirect') }}" class="btn btn-xs btn-light-danger py-1 px-3 fw-bold fs-9" onclick="trackEscalation('create_ticket')">
                            <i class="bi bi-ticket-detailed me-1"></i> Buat Tiket
                        </a>
                        <a href="https://wa.me/628118005373" target="_blank" class="btn btn-xs btn-light-success py-1 px-2 fw-semibold fs-9" title="WhatsApp Customer Support" onclick="trackEscalation('contact_admin')">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            `;

            botRow.innerHTML = `
                <div class="symbol symbol-35px symbol-circle d-flex align-items-center justify-content-center mt-1 shrink-0" style="background: #002147;">
                    <i class="bi bi-robot fs-4" style="color: #C5A059;"></i>
                </div>
                <div class="p-4 rounded-4 bg-white shadow-sm border text-dark fs-6" style="border-top-left-radius: 4px !important;">
                    ${badgeHtml}
                    <div class="text-gray-800 fs-6 lh-base message-content">
                        ${renderFormattedText(data.message)}
                    </div>
                    ${suggestionsHtml}
                    ${actionBarHtml}
                </div>
            `;

            messages.appendChild(botRow);
            scrollToBottom();
        }

        function appendSystemErrorBubble(msg) {
            const errRow = document.createElement('div');
            errRow.className = 'd-flex align-items-start gap-3 me-auto';
            errRow.innerHTML = `
                <div class="symbol symbol-35px symbol-circle bg-light-danger text-danger d-flex align-items-center justify-content-center mt-1 shrink-0">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                </div>
                <div class="p-3 rounded-4 bg-light-danger text-danger fs-7">
                    ${escapeHtml(msg)}
                </div>
            `;
            messages.appendChild(errRow);
            scrollToBottom();
        }

        window.submitFeedback = async function(containerId, faqId, status) {
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = status === 'helped' 
                    ? `<span class="badge badge-light-success fs-9"><i class="bi bi-check me-1"></i> Terima kasih atas tanggapan Anda!</span>`
                    : `<span class="badge badge-light-danger fs-9"><i class="bi bi-info-circle me-1"></i> Terima kasih, tanggapan Anda dicatat untuk peningkatan sistem.</span>`;
            }

            try {
                await fetch("{{ route('faq.chat.feedback') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        session_id: sessionId,
                        faq_id: faqId,
                        status: status
                    })
                });
            } catch (e) {}
        };

        window.trackEscalation = async function(action) {
            try {
                await fetch("{{ route('faq.chat.action') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        session_id: sessionId,
                        action: action
                    })
                });
            } catch (e) {}
        };

        function renderFormattedText(text) {
            if (!text) return '';
            // Strip legacy footnotes or disclaimers
            let cleaned = text.replace(/\*?\s*\(\s*💡[^\)]*\)\.?\s*\*?/g, '').trim();
            let escaped = escapeHtml(cleaned);

            // Bold **text**
            escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

            // Bullets * text or - text
            escaped = escaped.replace(/^\s*[\*\-]\s+(.*)$/gm, '<li class="ms-3 mb-1">$1</li>');

            // Numbered items 1. text
            escaped = escaped.replace(/^\s*(\d+)\.\s+(.*)$/gm, '<li class="ms-3 mb-1"><strong>$1.</strong> $2</li>');

            // Wrap contiguous <li> with <ul>
            escaped = escaped.replace(/(<li.*<\/li>)/s, '<ul class="ps-2 my-2">$1</ul>');

            // Newlines to <br>
            escaped = escaped.replace(/\n{2,}/g, '<div class="my-2"></div>');
            escaped = escaped.replace(/\n/g, '<br>');

            return escaped;
        }

        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.toString().replace(/[&<>"']/g, m => map[m]);
        }
    })();
</script>
@endsection
