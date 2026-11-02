{{-- Global FAQ & AI Chat Floating Widget --}}
@php
    $defaultFaqTemplates = \App\Models\Faq::where('is_active', true)->orderBy('id', 'asc')->take(5)->get(['id', 'question', 'category']);
@endphp
<style>
    .faq-floating-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 54px;
        height: 54px;
        background: linear-gradient(135deg, #002147 0%, #003366 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(0, 33, 71, 0.35);
        cursor: pointer;
        z-index: 9999;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid rgba(197, 160, 89, 0.4);
    }
    .faq-floating-btn:hover {
        transform: scale(1.08) translateY(-2px);
        box-shadow: 0 12px 28px rgba(0, 33, 71, 0.45);
        border-color: #C5A059;
    }
    .faq-chat-window {
        position: fixed;
        bottom: 85px;
        right: 20px;
        width: 385px;
        height: 520px;
        max-height: calc(100vh - 105px);
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 12px 35px rgba(0, 33, 71, 0.25);
        border: 1px solid rgba(0, 33, 71, 0.12);
        display: flex;
        flex-direction: column;
        z-index: 9999;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        transform-origin: bottom right;
    }
    @media (max-width: 576px) {
        .faq-chat-window {
            right: 10px !important;
            left: 10px !important;
            bottom: 75px !important;
            width: auto !important;
            height: calc(100vh - 90px) !important;
            max-height: calc(100vh - 90px) !important;
            border-radius: 14px !important;
        }
        .faq-floating-btn {
            right: 15px !important;
            bottom: 15px !important;
            width: 48px !important;
            height: 48px !important;
        }
        .faq-msg {
            max-width: 95% !important;
            font-size: 12px !important;
        }
    }
    @media (min-width: 577px) and (max-width: 768px) {
        .faq-chat-window {
            width: 350px !important;
            height: 480px !important;
            bottom: 80px !important;
            right: 15px !important;
        }
    }
    .faq-chat-window.hidden-widget {
        opacity: 0;
        transform: scale(0.85);
        pointer-events: none;
        display: none !important;
    }
    .faq-widget-header {
        flex-shrink: 0;
        background: #002147;
        color: #FFFFFF;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #C5A059;
    }
    .faq-widget-body {
        flex: 1 1 0px !important;
        min-height: 0 !important;
        height: auto !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        padding: 12px;
        background: #F8FAFD;
        display: flex;
        flex-direction: column;
        gap: 10px;
        scroll-behavior: smooth;
    }
    .faq-widget-body::-webkit-scrollbar {
        width: 5px;
    }
    .faq-widget-body::-webkit-scrollbar-track {
        background: transparent;
    }
    .faq-widget-body::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 4px;
    }
    .faq-widget-body::-webkit-scrollbar-thumb:hover {
        background: #94A3B8;
    }
    .faq-msg {
        max-width: 90%;
        padding: 9px 12px;
        border-radius: 14px;
        font-size: 12.5px;
        line-height: 1.5;
        word-break: break-word;
    }
    .faq-msg.user {
        align-self: flex-end;
        background: #002147;
        color: #FFFFFF;
        border-bottom-right-radius: 3px;
    }
    .faq-msg.bot {
        align-self: flex-start;
        background: #FFFFFF;
        color: #1E293B;
        border: 1px solid #E2E8F0;
        border-bottom-left-radius: 3px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
    }
    .faq-msg.bot strong {
        color: #002147;
        font-weight: 600;
    }
    .faq-quick-chip {
        display: block;
        padding: 8px 10px;
        background: #FFFFFF;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 500;
        color: #002147;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        margin-bottom: 4px;
        text-align: left;
        line-height: 1.35;
        word-break: break-word;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .faq-quick-chip:hover {
        background: #002147;
        color: #C5A059 !important;
        border-color: #002147;
        transform: translateX(2px);
    }
    .faq-quick-chip:hover span {
        color: #FFFFFF !important;
    }
    .faq-quick-chip:hover i {
        color: #C5A059 !important;
    }
    .faq-action-bar {
        border-top: 1px solid #EEF2F6;
        padding-top: 5px;
        margin-top: 7px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11px;
    }
    .faq-widget-footer {
        flex-shrink: 0;
        padding: 10px 12px;
        background: #FFFFFF;
        border-top: 1px solid #E2E8F0;
    }
</style>

<div id="faqChatFloatingContainer">
    <!-- Floating Circular Trigger Button with SIAK Dukcapil Logo -->
    <div id="faqFloatingTrigger" class="faq-floating-btn" title="Buka Asisten Chat FAQ Dukcapil">
        <img src="{{ asset('template/dist/assets/media/logos/logos.png') }}" alt="SIAK Dukcapil" style="width: 32px; height: 32px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
    </div>

    <!-- Floating Chat Window -->
    <div id="faqChatFloatingWindow" class="faq-chat-window hidden-widget">
        <!-- Header -->
        <div class="faq-widget-header">
            <div class="d-flex align-items-center" style="gap: 10px;">
                <div style="width: 34px; height: 34px; border-radius: 50%; background: #ffffff; padding: 2px; border: 1.5px solid #C5A059; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25); overflow: hidden;">
                    <img src="{{ asset('template/dist/assets/media/logos/logos.png') }}" alt="SIAK" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="d-flex flex-column justify-content-center">
                    <span class="text-white fw-bold fs-6" style="letter-spacing: 0.3px; line-height: 1.2;">Asisten Dukcapil</span>
                    <span class="d-flex align-items-center text-white-50 mt-1" style="font-size: 11px !important; line-height: 1;">
                        <span style="display: inline-block; width: 7px; height: 7px; background-color: #50CD89; border-radius: 50%; margin-right: 5px; box-shadow: 0 0 6px rgba(80, 205, 137, 0.9); flex-shrink: 0;"></span>
                        Online • Siap Membantu
                    </span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-1">
                <a href="{{ route('faq.chat.index') }}" target="_blank" class="btn btn-sm btn-icon text-white text-hover-warning p-1" title="Buka Halaman Penuh" style="opacity: 0.85;">
                    <i class="bi bi-box-arrow-up-right fs-6"></i>
                </a>
                <button type="button" class="btn btn-sm btn-icon text-white text-hover-warning p-1" id="faqWidgetReset" title="Reset Percakapan" style="opacity: 0.85;">
                    <i class="bi bi-arrow-clockwise fs-5"></i>
                </button>
                <button type="button" class="btn btn-sm btn-icon text-white text-hover-warning p-1" id="faqWidgetClose" title="Tutup" style="opacity: 0.85;">
                    <i class="bi bi-x-lg fs-5"></i>
                </button>
            </div>
        </div>

        <!-- Chat Messages Body (Strictly Scrollable, never expands) -->
        <div class="faq-widget-body" id="faqWidgetMessages">
            <div class="faq-msg bot" id="faqWelcomeMessage">
                @if($defaultFaqTemplates->count() > 0)
                    <div class="mb-2">Halo kak! 👋 Saya asisten pintar sistem ticketing & layanan Dukcapil. Silakan tanyakan kendala Anda atau pilih solusi resmi berikut:</div>
                    <div id="faqQuickChipsContainer" class="d-flex flex-column gap-1">
                        @foreach($defaultFaqTemplates as $tmpl)
                            <div class="faq-quick-chip" onclick="sendFaqWidgetQuick({{ json_encode($tmpl->question) }})">
                                <i class="bi bi-patch-question-fill text-primary me-1 fs-8"></i>
                                <span>{{ $tmpl->question }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div>Halo kak! 👋 Saya asisten pintar sistem ticketing & layanan Dukcapil. Silakan ketik pertanyaan atau kendala Anda di bawah, saya siap membantu.</div>
                @endif
            </div>
        </div>

        <!-- Input Box -->
        <div class="faq-widget-footer">
            <form id="faqWidgetForm" class="d-flex align-items-center gap-2">
                <input type="text" id="faqWidgetInput" class="form-control form-control-sm form-control-solid rounded-pill px-3 fs-7" placeholder="Ketik pertanyaan Anda..." autocomplete="off">
                <button type="submit" class="btn btn-sm btn-icon btn-primary rounded-circle d-flex align-items-center justify-content-center" style="background-color: #002147; border: none; width: 34px; height: 34px; flex-shrink: 0;" id="faqWidgetSendBtn" title="Kirim Pesan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#C5A059">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const trigger = document.getElementById('faqFloatingTrigger');
        const chatWindow = document.getElementById('faqChatFloatingWindow');
        const closeBtn = document.getElementById('faqWidgetClose');
        const resetBtn = document.getElementById('faqWidgetReset');
        const form = document.getElementById('faqWidgetForm');
        const input = document.getElementById('faqWidgetInput');
        const messages = document.getElementById('faqWidgetMessages');

        // Store initial default welcome templates HTML
        const welcomeTemplateContainer = document.getElementById('faqQuickChipsContainer');
        const defaultWelcomeChipsHtml = welcomeTemplateContainer ? welcomeTemplateContainer.innerHTML : '';

        // Retain session ID consistently across page navigation
        let sessionId = localStorage.getItem('faq_chat_session_id') || ('sess_' + Math.random().toString(36).substring(2) + Date.now());
        localStorage.setItem('faq_chat_session_id', sessionId);

        // Check if widget was open previously
        if (localStorage.getItem('faq_widget_open') === '1' && chatWindow) {
            chatWindow.classList.remove('hidden-widget');
        }

        // ==================== LOAD SESSION HISTORY ====================
        let isHistoryLoaded = false;
        async function loadWidgetHistory() {
            if (isHistoryLoaded) return;
            try {
                const res = await fetch("{{ route('faq.chat.history') }}?session_id=" + encodeURIComponent(sessionId), {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await res.json();
                if (json.success && json.session_id) {
                    sessionId = json.session_id;
                    localStorage.setItem('faq_chat_session_id', sessionId);

                    if (json.messages && json.messages.length > 0) {
                        messages.innerHTML = ''; // Clear default welcome placeholder
                        json.messages.forEach(msg => {
                            if (msg.role === 'user') {
                                const userBubble = document.createElement('div');
                                userBubble.className = 'faq-msg user';
                                userBubble.textContent = msg.message;
                                messages.appendChild(userBubble);
                            } else {
                                const botBubble = document.createElement('div');
                                botBubble.className = 'faq-msg bot';
                                let html = '';
                                const faqIdVal = msg.faq ? msg.faq.id : 'null';

                                if (msg.source === 'template') {
                                    const qTitle = msg.faq ? msg.faq.question : 'Template Solusi Resmi';
                                    html += `<div class="badge badge-light-success py-1 px-2 fs-9 mb-1"><i class="bi bi-check-circle-fill text-success me-1"></i> Solusi Terverifikasi</div>`;
                                    html += `<div class="fw-bold text-primary mb-1">${qTitle}</div>`;
                                } else {
                                    html += `<div class="badge badge-light-primary py-1 px-2 fs-9 mb-1"><i class="bi bi-robot text-primary me-1"></i> Asisten Dukcapil</div>`;
                                }
                                html += `<div>${formatText(msg.message)}</div>`;
                                html += renderActionBar(faqIdVal, msg.feedback_status);
                                botBubble.innerHTML = html;
                                messages.appendChild(botBubble);
                            }
                        });
                        messages.scrollTop = messages.scrollHeight;
                    }
                }
                isHistoryLoaded = true;
            } catch (e) {
                isHistoryLoaded = true;
            }
        }

        // Auto load conversation history on page load
        loadWidgetHistory();

        if (trigger && chatWindow) {
            trigger.addEventListener('click', function() {
                chatWindow.classList.toggle('hidden-widget');
                const isOpen = !chatWindow.classList.contains('hidden-widget');
                localStorage.setItem('faq_widget_open', isOpen ? '1' : '0');
                if (isOpen) {
                    loadWidgetHistory();
                    setTimeout(() => {
                        messages.scrollTop = messages.scrollHeight;
                        if (input) input.focus();
                    }, 50);
                }
            });
            closeBtn.addEventListener('click', function() {
                chatWindow.classList.add('hidden-widget');
                localStorage.setItem('faq_widget_open', '0');
            });
        }

        // Explicit User Reset Button Only
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
                        const json = await res.json();
                        if (json.session_id) {
                            sessionId = json.session_id;
                            localStorage.setItem('faq_chat_session_id', sessionId);
                        }
                    } catch (e) {
                        sessionId = 'sess_' + Math.random().toString(36).substring(2) + Date.now();
                        localStorage.setItem('faq_chat_session_id', sessionId);
                    }

                    messages.innerHTML = `
                        <div class="faq-msg bot">
                            <div class="mb-2">Halo kak! 👋 Obrolan telah direset. Silakan ketik pertanyaan Anda atau pilih solusi resmi berikut:</div>
                            <div class="d-flex flex-column gap-1">${defaultWelcomeChipsHtml}</div>
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
                        title: 'Mulai Percakapan Baru?',
                        text: 'Riwayat percakapan saat ini akan dibersihkan.',
                        icon: 'question',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: '<i class="bi bi-arrow-clockwise me-1"></i> Ya, Reset',
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
                    if (confirm('Apakah Anda ingin mereset dan memulai percakapan baru?')) {
                        doReset();
                    }
                }
            });
        }

        window.sendFaqWidgetQuick = function(text) {
            if (input) {
                input.value = text;
                form.dispatchEvent(new Event('submit'));
            }
        };

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;

                // Append user message
                const userBubble = document.createElement('div');
                userBubble.className = 'faq-msg user';
                userBubble.textContent = text;
                messages.appendChild(userBubble);
                input.value = '';
                messages.scrollTop = messages.scrollHeight;

                // Append typing indicator
                const typingBubble = document.createElement('div');
                typingBubble.className = 'faq-msg bot text-muted fst-italic';
                typingBubble.id = 'faqWidgetTyping';
                typingBubble.innerHTML = '<span class="spinner-border spinner-border-sm text-primary me-2"></span>Sedang menyiapkan jawaban lengkap...';
                messages.appendChild(typingBubble);
                messages.scrollTop = messages.scrollHeight;

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
                    const typingEl = document.getElementById('faqWidgetTyping');
                    if (typingEl) typingEl.remove();

                    if (json.success) {
                        const data = json.data;
                        const botBubble = document.createElement('div');
                        botBubble.className = 'faq-msg bot';

                        let html = '';
                        const faqIdVal = data.faq ? data.faq.id : 'null';

                        if (data.source === 'template') {
                            const qTitle = data.faq ? data.faq.question : 'Template Solusi Resmi';
                            const ansText = data.message || (data.faq ? data.faq.answer : '');
                            html += `<div class="badge badge-light-success py-1 px-2 fs-9 mb-1"><i class="bi bi-check-circle-fill text-success me-1"></i> Solusi Terverifikasi</div>`;
                            html += `<div class="fw-bold text-primary mb-1">${qTitle}</div>`;
                            html += `<div>${formatText(ansText)}</div>`;
                        } else {
                            // Assistant response
                            if (data.is_multi_turn) {
                                html += `<div class="badge badge-light-warning text-dark py-1 px-2 fs-9 mb-1" style="background:#FFF3CD;"><i class="bi bi-stars text-warning me-1"></i> Asisten Dukcapil (Lanjutan)</div>`;
                            } else {
                                html += `<div class="badge badge-light-primary py-1 px-2 fs-9 mb-1"><i class="bi bi-robot text-primary me-1"></i> Asisten Dukcapil</div>`;
                            }
                            html += `<div>${formatText(data.message)}</div>`;
                            
                            // If suggestions exist
                            if (data.suggestions && data.suggestions.length > 0) {
                                html += `<div class="mt-2 pt-1 border-top border-gray-100">`;
                                html += `<div class="text-muted fw-semibold mb-1" style="font-size: 11px;">Topik Terkait:</div>`;
                                html += `<div class="d-flex flex-column gap-1">`;
                                data.suggestions.forEach(s => {
                                    html += `<div class="faq-quick-chip" onclick="sendFaqWidgetQuick('${escapeQuotes(s.question)}')"><i class="bi bi-patch-question-fill text-primary me-1 fs-8"></i> ${escapeHtml(s.question)}</div>`;
                                });
                                html += `</div></div>`;
                            }
                        }

                        // Compact 1-line Action Bar (Feedback + Sleek Ticket Button)
                        html += renderActionBar(faqIdVal, null);

                        botBubble.innerHTML = html;
                        messages.appendChild(botBubble);
                    }
                } catch (err) {
                    const typingEl = document.getElementById('faqWidgetTyping');
                    if (typingEl) typingEl.remove();

                    const errBubble = document.createElement('div');
                    errBubble.className = 'faq-msg bot text-danger';
                    errBubble.textContent = 'Gagal memproses pesan. Silakan coba sesaat lagi.';
                    messages.appendChild(errBubble);
                }

                messages.scrollTop = messages.scrollHeight;
            });
        }

        function renderActionBar(faqIdVal, feedbackStatus) {
            let feedbackHtml = '';
            if (feedbackStatus === 'helped') {
                feedbackHtml = `<span class="badge badge-light-success py-1 px-2" style="font-size: 10px;">Terima kasih feedback Anda!</span>`;
            } else if (feedbackStatus === 'not_helped') {
                feedbackHtml = `<span class="badge badge-light-secondary py-1 px-2" style="font-size: 10px;">Terima kasih feedback Anda!</span>`;
            } else {
                feedbackHtml = `
                    <div class="d-flex align-items-center gap-1">
                        <span class="text-muted" style="font-size: 10.5px;">Membantu?</span>
                        <button type="button" class="btn btn-icon btn-xs btn-light-success p-1" style="width: 22px; height: 22px; border-radius: 4px;" title="Membantu" onclick="submitWidgetFeedback('${faqIdVal}', 'helped', this)">
                            <i class="bi bi-hand-thumbs-up" style="font-size: 11px;"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-xs btn-light-secondary p-1" style="width: 22px; height: 22px; border-radius: 4px;" title="Kurang membantu" onclick="submitWidgetFeedback('${faqIdVal}', 'not_helped', this)">
                            <i class="bi bi-hand-thumbs-down" style="font-size: 11px;"></i>
                        </button>
                    </div>
                `;
            }

            return `
                <div class="faq-action-bar">
                    ${feedbackHtml}
                    <a href="{{ route('ticket.create.redirect') }}" class="btn btn-xs btn-light-danger py-1 px-2 fw-semibold d-inline-flex align-items-center text-nowrap" style="border-radius: 6px; font-size: 11px;" onclick="logWidgetEscalation('create_ticket')">
                        <i class="bi bi-ticket-perforated me-1 text-danger"></i> Buat Tiket
                    </a>
                </div>
            `;
        }

        window.submitWidgetFeedback = async function(faqId, status, btn) {
            const container = btn.closest('.d-flex');
            if (container) {
                container.innerHTML = `<span class="badge badge-light-${status === 'helped' ? 'success' : 'secondary'} py-1 px-2" style="font-size: 10px;">Terima kasih feedback Anda!</span>`;
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
                        faq_id: faqId === 'null' ? null : faqId,
                        status: status
                    })
                });
            } catch (e) {}
        };

        window.logWidgetEscalation = async function(action) {
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

        function escapeQuotes(str) {
            return (str || '').replace(/'/g, "\\'");
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str || '';
            return div.innerHTML;
        }

        function formatText(text) {
            if (!text) return '';
            // Strip any legacy footnotes
            let cleaned = text.replace(/\*?\s*\(\s*💡[^\)]*\)\.?\s*\*?/g, '').trim();

            // Headings ###
            cleaned = cleaned.replace(/^###\s*(.*$)/gim, '<strong class="text-primary d-block mt-2 mb-1">$1</strong>');
            
            // Bold **text**
            cleaned = cleaned.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            
            // Bullet list items
            cleaned = cleaned.replace(/^[\*\-]\s+(.*$)/gim, '<div class="d-flex align-items-start gap-1 mb-1"><span class="text-primary me-1">•</span><span>$1</span></div>');
            
            // Numbered list items
            cleaned = cleaned.replace(/^(\d+)\.\s+(.*$)/gim, '<div class="d-flex align-items-start gap-1 mb-1"><span class="fw-bold text-dark me-1">$1.</span><span>$2</span></div>');
            
            // Line breaks
            cleaned = cleaned.replace(/\n{2,}/g, '<div class="my-2"></div>');
            cleaned = cleaned.replace(/\n/g, '<br>');
            return cleaned;
        }
    })();
</script>
