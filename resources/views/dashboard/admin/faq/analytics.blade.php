@extends('layouts.dashboard.app')

@section('title')
    Monitoring & Analisis FAQ | SIAK Dukcapil
@endsection

@section('content')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Monitoring FAQ
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Statistik Interaksi Tiket & Monitoring Kuota Pemakaian</small>
            </h1>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center p-4 mb-5">
                <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!--begin::Nav Tabs (Left: Tiket & FAQ, Right: Kuota Pemakaian)-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-6 fw-bold mb-6 gap-2">
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-3 active d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab_analytics_ticket">
                    <i class="bi bi-ticket-detailed-fill text-primary fs-4"></i>
                    <span>Statistik Tiket & FAQ</span>
                    <span class="badge badge-light-primary fw-bolder fs-8 ms-1">{{ number_format($totalSessions) }} Sesi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-3 d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab_analytics_quota">
                    <i class="bi bi-cpu-fill text-warning fs-4"></i>
                    <span>Monitoring Kuota Pemakaian</span>
                    <span class="badge badge-light-{{ $quotaStatus }} fw-bolder fs-8 ms-1" id="tabBadgeQuota">{{ $aiRequestsToday }}/{{ number_format($geminiDailyLimit) }}</span>
                </a>
            </li>
        </ul>
        <!--end::Nav Tabs-->

        <!--begin::Tab Contents-->
        <div class="tab-content" id="analyticsTabContent">

            <!-- ==================== TAB 1: STATISTIK TIKET & FAQ ==================== -->
            <div class="tab-pane fade show active" id="tab_analytics_ticket" role="tabpanel">

                <!-- 1. STAT CARDS ROW (MORE INFORMATIVE & ELEVATED DESIGN) -->
                <div class="row g-5 g-xl-6 mb-6">
                    <!--Total Sessions-->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-flush shadow-sm bg-white border border-gray-200 h-100">
                            <div class="card-body p-6 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fw-bold fs-7 text-uppercase tracking-wider">Total Sesi Obrolan</span>
                                    <div class="w-35px h-35px rounded-circle bg-light-primary d-flex align-items-center justify-content-center">
                                        <i class="bi bi-chat-left-text-fill text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="fs-2hx fw-bolder text-dark">{{ number_format($totalSessions) }}</span>
                                        <span class="text-muted fs-8 fw-semibold">sesi</span>
                                    </div>
                                    <div class="text-muted fs-8 mt-1">
                                        <i class="bi bi-question-circle text-gray-400 me-1"></i> {{ number_format($totalQuestions) }} pertanyaan diajukan
                                    </div>
                                </div>
                                <div class="progress h-4px w-100 bg-light-primary rounded" style="overflow: hidden;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Helpful Rate-->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-flush shadow-sm bg-white border border-gray-200 h-100">
                            <div class="card-body p-6 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fw-bold fs-7 text-uppercase tracking-wider">Tingkat Membantu</span>
                                    <div class="w-35px h-35px rounded-circle bg-light-success d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hand-thumbs-up-fill text-success fs-4"></i>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="fs-2hx fw-bolder {{ $helprate >= 60 ? 'text-success' : ($helprate > 0 ? 'text-warning' : 'text-muted') }}">{{ $helprate }}%</span>
                                        <span class="text-muted fs-8 fw-semibold">rating puas</span>
                                    </div>
                                    <div class="text-muted fs-8 mt-1">
                                        <i class="bi bi-check-circle text-success me-1"></i> {{ $likeCount }} puas dari {{ $totalFeedback }} ulasan
                                    </div>
                                </div>
                                <div class="progress h-4px w-100 bg-light rounded" style="overflow: hidden;">
                                    <div class="progress-bar {{ $helprate >= 60 ? 'bg-success' : 'bg-warning' }}" role="progressbar" style="width: {{ max(4, $helprate) }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Source Comparison: Template vs Sistem-->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-flush shadow-sm bg-white border border-gray-200 h-100">
                            <div class="card-body p-6 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fw-bold fs-7 text-uppercase tracking-wider">Sumber Jawaban</span>
                                    <span class="badge badge-light-primary fw-bolder fs-8 py-1 px-2">{{ $totalAnswers }} Dijawab</span>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot bg-primary w-8px h-8px"></span>
                                            <span class="text-dark fw-bold fs-7">Template</span>
                                            <span class="text-primary fw-bolder fs-6 ms-1">{{ $templateCount }}</span>
                                            <span class="text-muted fs-8">({{ $templatePct }}%)</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="bullet bullet-dot w-8px h-8px" style="background-color: #6366f1;"></span>
                                            <span class="text-dark fw-bold fs-7">Chat Sistem</span>
                                            <span class="fw-bolder fs-6 ms-1" style="color: #6366f1;">{{ $aiCount }}</span>
                                            <span class="text-muted fs-8">({{ $aiPct }}%)</span>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-8 mt-1">
                                        Rasio jawaban template DB vs pencarian AI
                                    </div>
                                </div>
                                <div class="progress h-6px w-100 bg-light rounded" style="overflow: hidden; display: flex;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $templatePct }}%;" title="Template DB: {{ $templateCount }} ({{ $templatePct }}%)"></div>
                                    <div class="progress-bar" role="progressbar" style="width: {{ $aiPct }}%; background-color: #6366f1;" title="Pencarian AI: {{ $aiCount }} ({{ $aiPct }}%)"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Perlu Evaluasi / Evaluasi Respon (Tanpa Eskalasi Tiket)-->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-flush shadow-sm bg-white border border-gray-200 h-100">
                            <div class="card-body p-6 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fw-bold fs-7 text-uppercase tracking-wider">Evaluasi Respon</span>
                                    <span class="badge badge-light-{{ $dislikeCount > 0 ? 'warning' : 'success' }} fw-bolder fs-8 py-1 px-2">
                                        {{ $totalFeedback }} Respon
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-hand-thumbs-up-fill text-success fs-6"></i>
                                            <span class="text-dark fw-bold fs-7">Disukai</span>
                                            <span class="text-success fw-bolder fs-6 ms-1">{{ $likeCount }}</span>
                                            <span class="text-muted fs-8">({{ $likePct }}%)</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-hand-thumbs-down-fill text-danger fs-6"></i>
                                            <span class="text-dark fw-bold fs-7">Kurang</span>
                                            <span class="text-danger fw-bolder fs-6 ms-1">{{ $dislikeCount }}</span>
                                            <span class="text-muted fs-8">({{ $dislikePct }}%)</span>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-8 mt-1">
                                        @if($dislikeCount > 0)
                                            <span class="text-danger fw-semibold">{{ $dislikeCount }} respon perlu perbaikan solusi</span>
                                        @else
                                            <span class="text-success fw-semibold">Belum ada komplain respon pengguna</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="progress h-6px w-100 bg-light rounded" style="overflow: hidden; display: flex;">
                                    @if($totalFeedback > 0)
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $likePct }}%;" title="Disukai: {{ $likeCount }} ({{ $likePct }}%)"></div>
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $dislikePct }}%;" title="Kurang Disukai: {{ $dislikeCount }} ({{ $dislikePct }}%)"></div>
                                    @else
                                        <div class="progress-bar bg-light-dark" role="progressbar" style="width: 100%;"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. CHARTS ROW -->
                <div class="row g-5 g-xl-6 mb-6">
                    <!--Daily Activity (Last 14 Days)-->
                    <div class="col-xl-6">
                        <div class="card card-flush shadow-sm h-100 bg-white border border-gray-200">
                            <div class="card-header pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-5 text-dark">Pertanyaan Harian</span>
                                    <span class="text-muted mt-1 fw-bold fs-7">Aktivitas 14 hari terakhir</span>
                                </h3>
                            </div>
                            <div class="card-body pt-2" style="position: relative; height: 300px;">
                                <canvas id="chartDailyTrend"></canvas>
                            </div>
                        </div>
                    </div>

                    <!--Monthly Activity (Current Year)-->
                    <div class="col-xl-6">
                        <div class="card card-flush shadow-sm h-100 bg-white border border-gray-200">
                            <div class="card-header pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-5 text-dark">Pertanyaan Bulanan ({{ date('Y') }})</span>
                                    <span class="text-muted mt-1 fw-bold fs-7">Distribusi volume pertanyaan per bulan</span>
                                </h3>
                            </div>
                            <div class="card-body pt-2" style="position: relative; height: 300px;">
                                <canvas id="chartMonthlyTrend"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. TOP QUESTIONS ROW (FULL WIDTH & DETAILED WITH SEARCH, FILTER & PAGINATION) -->
                <div class="card card-flush shadow-sm bg-white border border-gray-200 mb-6">
                    <div class="card-header pt-5 pb-3">
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between w-100 gap-3">
                            <div>
                                <h3 class="card-title align-items-start flex-column m-0">
                                    <span class="card-label fw-bolder fs-5 text-dark">Top Pertanyaan Terbanyak</span>
                                    <span class="text-muted mt-1 fw-bold fs-7">Daftar pertanyaan dan kendala yang paling sering diajukan beserta status penanganan & respons pengguna</span>
                                </h3>
                            </div>
                            <span class="badge badge-light-primary fw-bolder fs-8 py-2 px-3">
                                <i class="bi bi-chat-left-dots-fill text-primary me-1"></i> <span id="topQuestionCountBadge">{{ $topQuestions->count() }}</span> Pertanyaan Populer
                            </span>
                        </div>

                        <!-- Filter & Search Toolbar (Sejajar / Inline & Compact) -->
                        <div class="d-flex align-items-center flex-wrap gap-3 pt-3 mt-2 border-top border-gray-200">
                            <div class="position-relative" style="width: 260px; min-width: 200px;">
                                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" id="searchTopQuestions" class="form-control form-control-sm form-control-solid ps-9 fs-7" placeholder="Cari pertanyaan, frekuensi (5x), solusi...">
                            </div>
                            <div style="width: 160px;">
                                <select id="filterTopSource" class="form-select form-select-sm form-select-solid fs-7">
                                    <option value="">Semua Sumber</option>
                                    <option value="template">Template Resmi</option>
                                    <option value="ai">Pencarian Sistem</option>
                                </select>
                            </div>
                            <div style="width: 160px;">
                                <select id="filterTopFeedback" class="form-select form-select-sm form-select-solid fs-7">
                                    <option value="">Semua Respon</option>
                                    <option value="liked">Disukai (Like)</option>
                                    <option value="disliked">Kurang Disukai</option>
                                    <option value="none">Belum Ada Respon</option>
                                </select>
                            </div>
                            <button type="button" id="btnResetTopFilter" class="btn btn-sm btn-light fs-8 text-nowrap" style="display: none;">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                            </button>
                            <div class="text-muted fs-8 ms-auto" id="topFilterStatusText"></div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-7 gy-3" id="tableTopQuestions">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-8 text-uppercase gs-0">
                                        <th style="width: 45px;">No</th>
                                        <th style="min-width: 250px;">Pertanyaan / Kendala</th>
                                        <th style="min-width: 280px;">Solusi / Jawaban Terkait</th>
                                        <th class="text-center" style="width: 140px;">Frekuensi</th>
                                        <th class="text-center" style="width: 150px;">Respon Pengguna</th>
                                        <th class="text-center" style="width: 140px;">Terakhir Ditanyakan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 fw-semibold" id="tbodyTopQuestions">
                                    @forelse($topQuestions as $index => $q)
                                        @php
                                            $solutionText = $q->faq ? $q->faq->answer : ($q->sample_ai_response ?: 'Belum ada catatan solusi tersimpan.');
                                            $sourceType = $q->faq ? 'template' : ($q->source === 'ai_search' ? 'ai' : 'other');
                                            $feedbackType = ($q->helpful_count > 0 && $q->unhelpful_count > 0) ? 'both' : ($q->helpful_count > 0 ? 'liked' : ($q->unhelpful_count > 0 ? 'disliked' : 'none'));
                                            $categoryText = $q->faq ? $q->faq->category : ($q->source === 'ai_search' ? 'Pencarian Sistem' : 'Umum');
                                        @endphp
                                        <tr class="top-question-row"
                                            data-question="{{ strtolower(e($q->question)) }}"
                                            data-solution="{{ strtolower(e($solutionText)) }}"
                                            data-category="{{ strtolower(e($categoryText)) }}"
                                            data-freq="{{ (int) $q->count }}"
                                            data-source="{{ $sourceType }}"
                                            data-feedback="{{ $feedbackType }}"
                                            data-has-like="{{ $q->helpful_count > 0 ? '1' : '0' }}"
                                            data-has-dislike="{{ $q->unhelpful_count > 0 ? '1' : '0' }}">
                                            <td class="top-row-num">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="text-dark fw-bold fs-7 mb-1">{{ $q->question }}</div>
                                                @if($q->faq)
                                                    <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #002147; font-size: 11px; font-weight: 600;">
                                                        <i class="bi bi-tag-fill" style="color: #002147; font-size: 10px;"></i> {{ $q->faq->category }}
                                                    </span>
                                                @elseif($q->source === 'ai_search')
                                                    <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded" style="background: #eef2ff; border: 1px solid #c7d2fe; color: #3730a3; font-size: 11px; font-weight: 600;">
                                                        <i class="bi bi-robot" style="color: #4f46e5; font-size: 11px;"></i> Pencarian Sistem
                                                    </span>
                                                @else
                                                    <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b; font-size: 11px; font-weight: 600;">
                                                        <i class="bi bi-chat-text" style="color: #64748b; font-size: 10px;"></i> Umum
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-gray-600 fs-8 text-truncate" style="max-width: 360px;" title="{{ $solutionText }}">
                                                    {{ Str::limit($solutionText, 110) }}
                                                </div>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                <span class="d-inline-block px-3 py-1 rounded" style="background: #f0f4f9; border: 1px solid #d0dbe9; color: #002147; font-size: 11px; font-weight: 700;">
                                                    {{ $q->count }}x Ditanyakan
                                                </span>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                @if($q->helpful_count > 0 || $q->unhelpful_count > 0)
                                                    <div class="d-inline-flex align-items-center gap-1">
                                                        @if($q->helpful_count > 0)
                                                             <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded" style="background: #e6f4ea; border: 1px solid #b7e1cd; color: #137333; font-size: 11px; font-weight: 700;" title="{{ $q->helpful_count }} Pengguna Terbantu (Like)">
                                                                <i class="bi bi-hand-thumbs-up-fill" style="color: #137333; font-size: 11px;"></i> {{ $q->helpful_count }}
                                                            </span>
                                                        @endif
                                                        @if($q->unhelpful_count > 0)
                                                            <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded" style="background: #fce8e6; border: 1px solid #fad2cf; color: #c5221f; font-size: 11px; font-weight: 700;" title="{{ $q->unhelpful_count }} Kurang Membantu (Dislike)">
                                                                <i class="bi bi-hand-thumbs-down-fill" style="color: #c5221f; font-size: 11px;"></i> {{ $q->unhelpful_count }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted fs-8">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center text-nowrap text-muted fs-8">
                                                {{ $q->last_asked_at ? Carbon\Carbon::parse($q->last_asked_at)->diffForHumans() : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="emptyTopQuestionsRow">
                                            <td colspan="6" class="text-center py-6 text-muted fs-7">
                                                <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                                                Belum ada data pertanyaan pengguna tercatat.
                                            </td>
                                        </tr>
                                    @endforelse
                                    <tr id="noMatchTopQuestionsRow" style="display: none;">
                                        <td colspan="6" class="text-center py-8 text-muted fs-7">
                                            <i class="bi bi-search fs-2 d-block mb-2 text-muted"></i>
                                            Tidak ditemukan pertanyaan yang cocok dengan filter pencarian.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer (Shows controls if > 10 data) -->
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pt-4 border-top gap-3" id="topPaginationWrapper">
                            <div class="text-muted fs-8" id="topPaginationInfo">
                                Menampilkan {{ $topQuestions->count() }} pertanyaan
                            </div>
                            <ul class="pagination pagination-sm m-0" id="topPaginationNav">
                                <!-- Dynamic Pagination buttons -->
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Tab 1-->

            <!-- ==================== TAB 2: MONITORING KUOTA PEMAKAIAN ==================== -->
            <div class="tab-pane fade" id="tab_analytics_quota" role="tabpanel">

                <!-- 1. FEATURED: QUOTA MONITOR & KEY MANAGEMENT -->
                <div class="card card-flush shadow-sm bg-white border border-gray-200 mb-6">
                    <div class="card-header py-4 px-6 d-flex align-items-center justify-content-between border-bottom" style="background: linear-gradient(135deg, #002147 0%, #003366 100%);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-45px symbol-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center">
                                <i class="bi bi-cpu-fill fs-2" style="color: #C5A059;"></i>
                            </div>
                            <div>
                                <span class="fw-bolder fs-5 text-white d-block">Monitoring Kuota Pemakaian</span>
                                <span class="text-white-50 fs-8">Status konsumsi kuota harian & manajemen batas panggilan sistem</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-light-{{ $quotaStatus }} fw-bold fs-7 px-3 py-2" id="badgeQuotaStatus">
                                ● {{ $quotaStatusText }}
                            </span>
                            <button type="button" class="btn btn-sm btn-warning fw-bold text-dark px-4" data-bs-toggle="modal" data-bs-target="#modalUpdateApiKey">
                                <i class="bi bi-key-fill text-dark me-1"></i> Perbarui API Key
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-6">
                        <div class="row align-items-center g-6">
                            <!--Left: Percentage Box-->
                            <div class="col-lg-4 col-xl-3 border-end">
                                <div class="d-flex flex-column align-items-start">
                                    <span class="text-muted fs-8 fw-bold text-uppercase tracking-wider mb-1">Konsumsi Kuota Hari Ini</span>
                                    <div class="d-flex align-items-baseline gap-2 mb-1">
                                        <span class="fs-3hx fw-bolder text-{{ $quotaStatus }}" id="displayUsagePercent">{{ $geminiUsagePercent }}%</span>
                                        <span class="text-muted fs-7 fw-semibold">terpakai</span>
                                    </div>
                                    <div class="text-gray-700 fs-7">
                                        <span class="fw-bolder text-dark" id="displayUsageToday">{{ $aiRequestsToday }}</span> dari <span class="fw-bolder text-dark" id="displayDailyLimit">{{ number_format($geminiDailyLimit) }}</span> batas panggilan/hari
                                    </div>
                                </div>
                            </div>

                            <!--Right: Progress Bar & Key Details-->
                            <div class="col-lg-8 col-xl-9">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-8 fw-semibold">Progres Kuota Harian</span>
                                    <span class="text-muted fs-8 fw-semibold">Reset otomatis setiap 24 jam</span>
                                </div>
                                <div class="progress h-20px w-100 rounded-pill bg-light mb-4 shadow-xs" style="overflow: hidden;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $quotaStatus }}" 
                                         id="progressBarUsage"
                                         role="progressbar" 
                                         style="width: {{ max(4, $geminiUsagePercent) }}%;" 
                                         aria-valuenow="{{ $geminiUsagePercent }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <span class="fs-8 fw-bold px-2">{{ $geminiUsagePercent }}%</span>
                                    </div>
                                </div>

                                <!--Status Details Pills-->
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="d-flex align-items-center gap-2 bg-light rounded-pill px-3 py-2 border">
                                        <i class="bi bi-shield-lock-fill text-primary"></i>
                                        <span class="text-muted fs-8">Kunci Aktif:</span>
                                        <span class="fw-bolder text-dark fs-8" id="displayActiveKeyName">{{ $activeKeyName }}</span>
                                        <code class="fw-bold text-primary fs-8 ms-1" id="displayMaskedKey">({{ $maskedApiKey }})</code>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-light rounded-pill px-3 py-2 border">
                                        <i class="bi bi-collection-fill text-warning"></i>
                                        <span class="text-muted fs-8">Koleksi:</span>
                                        <span class="badge badge-light-warning fw-bold fs-8" id="displaySavedKeysCount">{{ $savedApiKeys->count() }} Kunci Tersimpan</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-light rounded-pill px-3 py-2 border">
                                        <i class="bi bi-calendar-check text-success"></i>
                                        <span class="text-muted fs-8">Bulan Ini:</span>
                                        <span class="fw-bolder text-dark fs-8">{{ number_format($aiRequestsThisMonth) }} panggilan</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-light rounded-pill px-3 py-2 border">
                                        <i class="bi bi-arrow-repeat text-info"></i>
                                        <span class="text-muted fs-8">Batas Baku:</span>
                                        <span class="badge badge-light-info fw-bold fs-8">1.500 RPD</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. LIVE TABLE: RECENT SYSTEM CHAT LOGS -->
                <div class="card card-flush shadow-sm bg-white border border-gray-200 mb-6">
                    <div class="card-header pt-5 d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-5 text-dark">Riwayat Panggilan Sistem Terkini</span>
                                <span class="text-muted mt-1 fw-bold fs-7">10 aktivitas pencarian jawaban otomatis sistem terkini</span>
                            </h3>
                        </div>
                        <span class="badge badge-light-warning fw-bold fs-8">Live Feed</span>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-7 gy-3">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-8 text-uppercase gs-0">
                                        <th>Waktu</th>
                                        <th>Pengguna</th>
                                        <th>Pertanyaan yang Diajukan</th>
                                        <th>Respon Singkat Asisten</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 fw-semibold">
                                    @forelse($recentAiLogs as $log)
                                        <tr>
                                            <td style="white-space: nowrap;">
                                                <div class="text-dark fw-bold">{{ $log->created_at->format('H:i') }} WIB</div>
                                                <small class="text-muted">{{ $log->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-semibold">{{ $log->user ? $log->user->name : 'Pengguna Guest' }}</span>
                                            </td>
                                            <td style="max-width: 250px;">
                                                <div class="text-dark fw-bold text-truncate" title="{{ $log->question }}">{{ $log->question }}</div>
                                            </td>
                                            <td style="max-width: 320px;">
                                                <div class="text-gray-600 fs-8 text-truncate" title="{{ $log->ai_response }}">
                                                    {{ Str::limit($log->ai_response ?: 'Respon terkirim', 95) }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($log->is_answer_found)
                                                    <span class="badge badge-light-success fw-bold fs-8">Terjawab</span>
                                                @else
                                                    <span class="badge badge-light-warning fw-bold fs-8">Pencarian</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-muted fs-7">
                                                <i class="bi bi-clock-history text-muted fs-2 d-block mb-2"></i>
                                                Belum ada aktivitas panggilan sistem tercatat hari ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Tab 2-->

        </div>
        <!--end::Tab Contents-->

    </div>
</div>
<!--end::Post-->

<!-- ==================== MODAL: GANTI / PERBARUI API KEY ==================== -->
<div class="modal fade" id="modalUpdateApiKey" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-4 px-6" style="background-color: #002147;">
                <h3 class="modal-title text-white fw-bolder d-flex align-items-center gap-2">
                    <i class="bi bi-key-fill text-warning fs-3"></i> Manajemen Kunci API
                </h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary text-white" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-2"></i>
                </div>
            </div>

            <div class="modal-body p-6">
                <!--Active Key Banner-->
                <div class="card bg-light-primary border border-primary border-opacity-25 rounded p-4 mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fs-8 fw-bold text-uppercase text-muted">Kunci Aktif Saat Ini:</span>
                        <span class="badge badge-success fw-bold fs-8">● Terpasang Aktif</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="fw-bolder text-dark fs-6" id="modalActiveKeyName">{{ $activeKeyName }}</div>
                            <code class="text-primary fw-bold fs-7" id="modalActiveMaskedKey">{{ $maskedApiKey }}</code>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-light-primary fw-bolder fs-8 py-2 px-3">
                                <i class="bi bi-shield-check text-primary me-1"></i> 1.500 Panggilan / Hari
                            </span>
                            <div class="text-muted fs-9 mt-1">Reset tiap 24 jam (07:00 WIB)</div>
                        </div>
                    </div>
                </div>

                <div id="apiKeyAlertContainer"></div>

                <!-- Tabs: Pilih Kunci Tersimpan vs Tambah Kunci Baru -->
                <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active py-2 fw-bold fs-8 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="pill" href="#tabModalSwitchKey">
                            <i class="bi bi-collection-fill text-warning"></i>
                            <span>Pilih Kunci Tersimpan ({{ $savedApiKeys->count() }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 fw-bold fs-8 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="pill" href="#tabModalAddNewKey">
                            <i class="bi bi-plus-circle-fill text-success"></i>
                            <span>+ Daftarkan Kunci Baru</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Beralih ke Kunci Tersimpan -->
                    <div class="tab-pane fade show active" id="tabModalSwitchKey" role="tabpanel">
                        <div class="p-4 border rounded bg-white mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-bold fs-8 text-gray-700 m-0">Pilih Kunci API dari Koleksi:</label>
                                <span class="badge badge-light-primary fw-bolder fs-9">Baku: 1.500 RPD</span>
                            </div>
                            
                            <select id="selectSavedApiKey" class="form-select form-select-solid fs-7 mb-3" onchange="updateSelectedKeyCard(this)">
                                @foreach($savedApiKeys as $keyItem)
                                    @php
                                        $statusSuffix = $keyItem->is_active ? ' — [Aktif]' : '';
                                        $quotaLabel = $keyItem->is_limit_exceeded 
                                            ? '0% Kuota (Limit Tercapai)' 
                                            : "{$keyItem->available_percent}% Kuota Tersedia (" . number_format($keyItem->remaining) . "/{$keyItem->daily_limit} sisa)";
                                    @endphp
                                    <option value="{{ $keyItem->id }}" 
                                            data-name="{{ $keyItem->name }}"
                                            data-masked="{{ $keyItem->masked_key }}"
                                            data-limit="{{ $keyItem->daily_limit }}"
                                            data-today="{{ $keyItem->calls_today }}"
                                            data-remaining="{{ $keyItem->remaining }}"
                                            data-available-percent="{{ $keyItem->available_percent }}"
                                            data-used-percent="{{ $keyItem->used_percent }}"
                                            data-is-active="{{ $keyItem->is_active ? 1 : 0 }}"
                                            data-is-limit="{{ $keyItem->is_limit_exceeded ? 1 : 0 }}"
                                            data-badge="{{ $keyItem->status_badge }}"
                                            data-status-label="{{ $keyItem->status_label }}"
                                            {{ $keyItem->is_active ? 'selected' : '' }}>
                                        {{ $keyItem->name }} ({{ $keyItem->masked_key }}){{ $statusSuffix }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <small class="text-muted fs-9">
                                    *Pilih kunci di atas dan terapkan untuk mengaktifkannya ke asisten AI.
                                </small>
                                <button type="button" class="btn btn-primary btn-sm fw-bold px-4" id="btnSwitchApiKey">
                                    <i class="bi bi-arrow-repeat me-1"></i> Terapkan Kunci Ini
                                </button>
                            </div>
                        </div>

                        <!-- Mini Table: Ringkasan Semua Kunci Tersimpan -->
                        <div class="border rounded p-3 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold fs-8 text-gray-700">Ringkasan Kuota Semua Kunci Tersimpan:</span>
                                <span class="badge badge-light-primary fs-9 fw-bold">{{ $savedApiKeys->count() }} Kunci</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle fs-8 mb-0 gy-2">
                                    <thead>
                                        <tr class="text-muted fw-bold border-bottom">
                                            <th>Nama Kunci</th>
                                            <th class="text-center">% Kuota Tersedia</th>
                                            <th class="text-center">Sisa Panggilan</th>
                                            <th class="text-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($savedApiKeys as $k)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-dark">{{ $k->name }}</div>
                                                    <code class="text-muted fs-9">{{ $k->masked_key }}</code>
                                                </td>
                                                <td class="text-center">
                                                    @if($k->is_limit_exceeded)
                                                        <span class="d-inline-block px-2 py-1 rounded fw-bold fs-9" style="background: #fce8e6; border: 1px solid #fad2cf; color: #c5221f;">
                                                            0% (Limit)
                                                        </span>
                                                    @elseif($k->available_percent <= 20)
                                                        <span class="d-inline-block px-2 py-1 rounded fw-bold fs-9" style="background: #fef7e0; border: 1px solid #feefc3; color: #b06000;">
                                                            {{ $k->available_percent }}%
                                                        </span>
                                                    @else
                                                        <span class="d-inline-block px-2 py-1 rounded fw-bold fs-9" style="background: #e6f4ea; border: 1px solid #b7e1cd; color: #137333;">
                                                            {{ $k->available_percent }}%
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center fw-semibold text-gray-700">
                                                    {{ number_format($k->remaining) }} / {{ number_format($k->daily_limit) }}
                                                </td>
                                                <td class="text-end">
                                                    @if($k->is_active)
                                                        <span class="badge badge-success fw-bold fs-9">● Aktif</span>
                                                    @else
                                                        <span class="badge badge-light fw-bold fs-9 text-muted">Cadangan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Daftarkan Kunci Baru ke Koleksi -->
                    <div class="tab-pane fade" id="tabModalAddNewKey" role="tabpanel">
                        <form id="formUpdateApiKey">
                            @csrf
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="fs-8 text-muted">Daftarkan API Key baru dari Google AI Studio:</span>
                                <a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener noreferrer" class="fs-8 fw-semibold text-primary text-hover-underline">
                                    <i class="bi bi-box-arrow-up-right fs-9 me-1"></i> Buka AI Studio
                                </a>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold fs-8 text-gray-700">Nama / Label Kunci (Opsional)</label>
                                <input type="text" id="inputKeyName" name="name" class="form-control form-control-solid fs-7" placeholder="Contoh: Kunci Akun Gmail Budi, Cadangan 2...">
                            </div>

                            <div class="mb-3">
                                <label class="required form-label fw-bold fs-8 text-gray-700">API Key</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key-fill text-warning"></i></span>
                                    <input type="password" id="inputApiKey" name="api_key" class="form-control form-control-solid fs-7" placeholder="Paste API Key di sini..." required autocomplete="off">
                                    <button type="button" class="btn btn-light" id="toggleApiKeyVisibility" title="Lihat/Sembunyikan Key">
                                        <i class="bi bi-eye-slash" id="toggleEyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2">
                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                    <input class="form-check-input" type="checkbox" id="checkSetActive" name="set_active" value="1" checked>
                                    <label class="form-check-label fs-8 text-gray-700" for="checkSetActive">
                                        Jadikan langsung sebagai kunci aktif
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm fw-bold px-4" id="btnSubmitApiKey">
                                    <span class="indicator-label"><i class="bi bi-shield-check me-1"></i> Uji & Simpan</span>
                                    <span class="indicator-progress" style="display: none;">
                                        <span class="spinner-border spinner-border-sm align-middle me-2"></span>Memverifikasi...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer py-3 px-6 bg-light d-flex justify-content-between">
                <div class="text-muted fs-9">
                    <i class="bi bi-info-circle text-primary me-1"></i> Kuota harian baku Flash Lite: 1.500 panggilan/hari.
                </div>
                <button type="button" class="btn btn-light btn-sm fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL: KONVERSI DRAFT JADI TEMPLATE FAQ RESMI ==================== -->
<div class="modal fade" id="modalConvertFaq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-4 px-6" style="background-color: #002147;">
                <h3 class="modal-title text-white fw-bolder d-flex align-items-center gap-2">
                    <i class="bi bi-journal-plus text-warning fs-3"></i> Konversi Pertanyaan Jadi Template FAQ Resmi
                </h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary text-white" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-2"></i>
                </div>
            </div>

            <form action="{{ route('admin.faq.convert') }}" method="POST">
                @csrf
                <input type="hidden" name="unanswered_id" id="convertUnansweredId">
                <input type="hidden" name="chat_log_id" id="convertChatLogId">

                <div class="modal-body p-6">
                    <div class="alert alert-light-success d-flex align-items-center p-3 mb-4">
                        <i class="bi bi-magic text-success fs-3 me-2"></i>
                        <div class="fs-8">
                            Draf pertanyaan dan solusi telah dimuat secara otomatis. Anda dapat meninjau dan menyesuaikan jawaban sebelum menjadikannya solusi baku.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Pertanyaan / Kasus Kendala</label>
                        <input type="text" name="question" id="convertQuestion" class="form-control form-control-solid fs-7" required>
                    </div>

                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Kategori Masalah</label>
                        <select name="category" id="convertCategory" class="form-select form-select-solid fs-7" required>
                            <option value="SIAK Terpusat">SIAK Terpusat</option>
                            <option value="Identitas Kependudukan Digital (IKD)">Identitas Kependudukan Digital (IKD)</option>
                            <option value="Jaringan & Koneksi">Jaringan & Koneksi</option>
                            <option value="Perangkat Keras & Printer">Perangkat Keras & Printer</option>
                            <option value="Dokumen Kependudukan">Dokumen Kependudukan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Jawaban Solusi Resmi</label>
                        <textarea name="answer" id="convertAnswer" class="form-control form-control-solid fs-7" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7">Kata Kunci Pencarian (Pisahkan dengan koma)</label>
                        <input type="text" name="keywords" id="convertKeywords" class="form-control form-control-solid fs-7" placeholder="contoh: siak, login, error, reset">
                    </div>
                </div>

                <div class="modal-footer py-3 px-6 bg-light">
                    <button type="button" class="btn btn-light btn-sm fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm fw-bold">
                        <i class="bi bi-check-circle me-1"></i> Terbitkan Jadi FAQ Resmi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Chart Pertanyaan Harian (Line Chart)
        const canvasDaily = document.getElementById('chartDailyTrend');
        if (canvasDaily) {
            const ctxDaily = canvasDaily.getContext('2d');
            new Chart(ctxDaily, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dailyLabels) !!},
                    datasets: [{
                        label: 'Pertanyaan Masuk',
                        data: {!! json_encode($dailyValues) !!},
                        backgroundColor: 'rgba(0, 33, 71, 0.12)',
                        borderColor: '#002147',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#002147',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 6,
                        pointRadius: 4,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#002147',
                            padding: 10,
                            titleFont: { size: 12 },
                            bodyFont: { size: 12 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, precision: 0 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Chart Pertanyaan Bulanan (Bar Chart)
        const canvasMonthly = document.getElementById('chartMonthlyTrend');
        if (canvasMonthly) {
            const ctxMonthly = canvasMonthly.getContext('2d');
            new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyLabels) !!},
                    datasets: [{
                        label: 'Total Pertanyaan',
                        data: {!! json_encode($monthlyValues) !!},
                        backgroundColor: 'rgba(197, 160, 89, 0.8)',
                        borderColor: '#C5A059',
                        borderWidth: 1.5,
                        borderRadius: 6,
                        hoverBackgroundColor: '#002147'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#002147',
                            padding: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, precision: 0 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 3. Toggle Password Visibility for API Key
        const toggleBtn = document.getElementById('toggleApiKeyVisibility');
        const inputKey = document.getElementById('inputApiKey');
        const eyeIcon = document.getElementById('toggleEyeIcon');
        if (toggleBtn && inputKey && eyeIcon) {
            toggleBtn.addEventListener('click', function() {
                if (inputKey.type === 'password') {
                    inputKey.type = 'text';
                    eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
                } else {
                    inputKey.type = 'password';
                    eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
                }
            });
        }

        const alertBox = document.getElementById('apiKeyAlertContainer');

        // 4. Beralih Kunci API Tersimpan (Switch Key)
        const btnSwitch = document.getElementById('btnSwitchApiKey');
        const selectSavedKey = document.getElementById('selectSavedApiKey');
        if (btnSwitch && selectSavedKey) {
            btnSwitch.addEventListener('click', async function() {
                const keyId = selectSavedKey.value;
                if (!keyId) return;

                btnSwitch.disabled = true;
                btnSwitch.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengalihkan...';

                try {
                    const res = await fetch("{{ route('admin.faq.switch_api_key') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ key_id: keyId })
                    });
                    const json = await res.json();
                    btnSwitch.disabled = false;
                    btnSwitch.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i> Aktifkan Kunci';

                    if (json.success) {
                        alertBox.innerHTML = `
                            <div class="alert alert-success d-flex align-items-center p-3 mb-4">
                                <i class="bi bi-check-circle-fill text-success fs-3 me-2"></i>
                                <span>${json.message}</span>
                            </div>
                        `;
                        setTimeout(() => window.location.reload(), 800);
                    } else {
                        alertBox.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center p-3 mb-4">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-2"></i>
                                <span>${json.message || 'Gagal mengalihkan kunci.'}</span>
                            </div>
                        `;
                    }
                } catch(e) {
                    btnSwitch.disabled = false;
                    btnSwitch.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i> Aktifkan Kunci';
                    alert('Gagal mengalihkan kunci.');
                }
            });
        }

        // 5. Daftarkan Kunci API Baru
        const formApiKey = document.getElementById('formUpdateApiKey');
        const btnSubmit = document.getElementById('btnSubmitApiKey');
        if (formApiKey && btnSubmit) {
            formApiKey.addEventListener('submit', async function(e) {
                e.preventDefault();
                alertBox.innerHTML = '';

                const label = btnSubmit.querySelector('.indicator-label');
                const progress = btnSubmit.querySelector('.indicator-progress');
                label.style.display = 'none';
                progress.style.display = 'inline-block';
                btnSubmit.disabled = true;

                const apiKey = document.getElementById('inputApiKey').value.trim();
                const keyName = document.getElementById('inputKeyName') ? document.getElementById('inputKeyName').value.trim() : '';
                const setActive = document.getElementById('checkSetActive') ? document.getElementById('checkSetActive').checked : true;

                try {
                    const res = await fetch("{{ route('admin.faq.update_api_key') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            api_key: apiKey,
                            name: keyName,
                            set_active: setActive
                        })
                    });

                    const json = await res.json();
                    label.style.display = 'inline-block';
                    progress.style.display = 'none';
                    btnSubmit.disabled = false;

                    if (json.success) {
                        alertBox.innerHTML = `
                            <div class="alert alert-success d-flex align-items-center p-3 mb-4">
                                <i class="bi bi-check-circle-fill text-success fs-3 me-2"></i>
                                <span>${json.message}</span>
                            </div>
                        `;
                        setTimeout(() => window.location.reload(), 900);
                    } else {
                        alertBox.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center p-3 mb-4">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-2"></i>
                                <span>${json.message || 'Verifikasi gagal.'}</span>
                            </div>
                        `;
                    }
                } catch (err) {
                    label.style.display = 'inline-block';
                    progress.style.display = 'none';
                    btnSubmit.disabled = false;
                    alertBox.innerHTML = `
                        <div class="alert alert-danger d-flex align-items-center p-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-2"></i>
                            <span>Terjadi gangguan koneksi ke server saat memverifikasi API Key.</span>
                        </div>
                    `;
                }
            });
        }
    });

    // 6. Event Delegation: Jadikan Solusi FAQ (Modal Convert)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-convert-eval');
        if (btn) {
            const id = btn.getAttribute('data-id');
            const question = btn.getAttribute('data-question') || '';
            let draft = btn.getAttribute('data-draft') || '';
            draft = draft.replace(/\*\(💡.*?\)\*/gs, '').trim();

            document.getElementById('convertUnansweredId').value = '';
            document.getElementById('convertChatLogId').value = id;
            document.getElementById('convertQuestion').value = question;
            document.getElementById('convertAnswer').value = draft;

            const words = question.toLowerCase().replace(/[^a-z0-9 ]/g, '').split(/\s+/).filter(w => w.length > 3);
            document.getElementById('convertKeywords').value = words.slice(0, 5).join(',');

            const modalEl = document.getElementById('modalConvertFaq');
            if (modalEl) {
                new bootstrap.Modal(modalEl).show();
            }
        }
    });

    // 7. Event Delegation: Lewati / Selesai (Tandai Selesai Ditinjau)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-mark-reviewed');
        if (btn) {
            const id = btn.getAttribute('data-id');

            Swal.fire({
                title: 'Tandai Selesai?',
                text: 'Pertanyaan ini akan dilewati dan ditandai selesai ditinjau tanpa dibuatkan template FAQ.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Ya, Selesai',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm fw-bold me-2',
                    cancelButton: 'btn btn-light btn-sm fw-bold'
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const row = document.getElementById(`evalRow_${id}`);
                    if (row) row.style.opacity = '0.5';

                    try {
                        const res = await fetch(`/admin/faqs/evaluation/${id}/reviewed`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const json = await res.json();
                        if (json.success) {
                            if (row) {
                                row.style.transition = 'all 0.35s ease';
                                row.style.opacity = '0';
                                setTimeout(() => {
                                    row.remove();
                                    const tbody = document.querySelector('#evalTableBody');
                                    if (tbody && tbody.querySelectorAll('tr').length === 0) {
                                        tbody.innerHTML = `
                                            <tr>
                                                <td colspan="4" class="text-center py-6 text-muted fs-7">
                                                    <i class="bi bi-patch-check-fill text-success fs-2 d-block mb-2"></i>
                                                    Semua pertanyaan pengguna berjalan optimal dan tidak ada keluhan respon negatif (dislike)!
                                                </td>
                                            </tr>
                                        `;
                                    }
                                }, 350);
                            }

                            Swal.fire({
                                title: 'Berhasil!',
                                text: json.message || 'Pertanyaan telah ditandai selesai ditinjau.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            if (row) row.style.opacity = '1';
                            Swal.fire({
                                title: 'Gagal!',
                                text: json.message || 'Gagal menandai pertanyaan.',
                                icon: 'error',
                                confirmButtonText: 'Tutup',
                                customClass: { confirmButton: 'btn btn-danger btn-sm fw-bold' },
                                buttonsStyling: false
                            });
                        }
                    } catch(err) {
                        if (row) row.style.opacity = '1';
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi gangguan koneksi ke server.',
                            icon: 'error',
                            confirmButtonText: 'Tutup',
                            customClass: { confirmButton: 'btn btn-danger btn-sm fw-bold' },
                            buttonsStyling: false
                        });
                    }
                }
            });
        }
    });

    // 8. Update Preview Kunci Terpilih & % Kuota Tersedia
    function updateSelectedKeyCard(selectEl) {
        if (!selectEl) selectEl = document.getElementById('selectSavedApiKey');
        if (!selectEl) return;

        const opt = selectEl.options[selectEl.selectedIndex];
        if (!opt) return;

        const name = opt.getAttribute('data-name') || '-';
        const masked = opt.getAttribute('data-masked') || '';
        const limit = parseInt(opt.getAttribute('data-limit') || '1500');
        const today = parseInt(opt.getAttribute('data-today') || '0');
        const remaining = parseInt(opt.getAttribute('data-remaining') || '1500');
        const availablePercent = parseFloat(opt.getAttribute('data-available-percent') || '100');
        const isActive = opt.getAttribute('data-is-active') === '1';
        const isLimit = opt.getAttribute('data-is-limit') === '1';

        const nameEl = document.getElementById('detailKeyName');
        const badgeEl = document.getElementById('detailKeyBadge');
        const percentEl = document.getElementById('detailKeyAvailablePercent');
        const callsEl = document.getElementById('detailKeyCallsText');
        const barEl = document.getElementById('detailKeyProgressBar');
        const remainingEl = document.getElementById('detailKeyRemainingText');

        if (nameEl) nameEl.textContent = `${name} (${masked})`;
        if (percentEl) percentEl.textContent = `${availablePercent}%`;
        if (callsEl) callsEl.textContent = `${today} / ${limit.toLocaleString('id-ID')} panggilan terpakai hari ini`;
        if (remainingEl) remainingEl.textContent = remaining.toLocaleString('id-ID');

        if (badgeEl) {
            badgeEl.className = 'badge fw-bold fs-9';
            if (isActive) {
                badgeEl.classList.add('badge-success');
                badgeEl.textContent = '● Terpasang Aktif';
            } else if (isLimit) {
                badgeEl.classList.add('badge-danger');
                badgeEl.textContent = 'Batas Kuota Tercapai';
            } else if (availablePercent <= 20) {
                badgeEl.classList.add('badge-warning');
                badgeEl.textContent = 'Kuota Menipis';
            } else {
                badgeEl.classList.add('badge-light-primary');
                badgeEl.textContent = 'Cadangan Siap Pakai';
            }
        }

        if (barEl) {
            barEl.style.width = `${availablePercent}%`;
            if (isLimit || availablePercent <= 0) {
                barEl.style.background = '#ef4444';
            } else if (availablePercent <= 20) {
                barEl.style.background = '#f59e0b';
            } else {
                barEl.style.background = '#10b981';
            }
        }
    }

    // 9. Uji Kuota Kunci Langsung tanpa perlu Mengaktifkan Terlebih Dahulu
    async function testCurrentKeyQuota() {
        const selectSavedKey = document.getElementById('selectSavedApiKey');
        const btn = document.getElementById('btnTestKeyQuota');
        if (!selectSavedKey || !btn) return;

        const keyId = selectSavedKey.value;
        if (!keyId) return;

        const origHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menguji...';

        try {
            const res = await fetch("{{ route('admin.faq.test_api_key') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ key_id: keyId })
            });

            const json = await res.json();
            btn.disabled = false;
            btn.innerHTML = origHtml;

            if (json.success) {
                Swal.fire({
                    title: 'Kunci Aktif & Kuota Tersedia!',
                    html: `<b>${json.key_name}</b> (${json.masked_key})<br><span class="text-success">${json.message}</span>`,
                    icon: 'success',
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn btn-primary btn-sm fw-bold' },
                    buttonsStyling: false
                });
            } else if (json.is_limit) {
                Swal.fire({
                    title: 'Batas Kuota Tercapai (Limit)!',
                    html: `<b>${json.key_name}</b><br><span class="text-danger">${json.message}</span>`,
                    icon: 'warning',
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn btn-warning btn-sm fw-bold text-dark' },
                    buttonsStyling: false
                });
            } else {
                Swal.fire({
                    title: 'Pemeriksaan Kunci Gagal',
                    html: `<b>${json.key_name}</b><br><span class="text-danger">${json.message}</span>`,
                    icon: 'error',
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn btn-danger btn-sm fw-bold' },
                    buttonsStyling: false
                });
            }
        } catch (e) {
            btn.disabled = false;
            btn.innerHTML = origHtml;
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat menguji kunci API.',
                icon: 'error',
                confirmButtonText: 'Tutup',
                customClass: { confirmButton: 'btn btn-danger btn-sm fw-bold' },
                buttonsStyling: false
            });
        }
    }

    // ==========================================
    // TOP QUESTIONS: SEARCH, FILTER & PAGINATION (10 per page)
    // ==========================================
    (function initTopQuestionsTable() {
        const searchInput = document.getElementById('searchTopQuestions');
        const filterSource = document.getElementById('filterTopSource');
        const filterFeedback = document.getElementById('filterTopFeedback');
        const btnReset = document.getElementById('btnResetTopFilter');
        const statusText = document.getElementById('topFilterStatusText');
        const countBadge = document.getElementById('topQuestionCountBadge');
        const navEl = document.getElementById('topPaginationNav');
        const infoEl = document.getElementById('topPaginationInfo');
        const noMatchRow = document.getElementById('noMatchTopQuestionsRow');
        const rows = Array.from(document.querySelectorAll('#tbodyTopQuestions .top-question-row'));

        if (!rows.length) {
            if (infoEl) infoEl.textContent = 'Menampilkan 0 pertanyaan';
            return;
        }

        const pageSize = 10;
        let currentPage = 1;
        let filteredRows = [...rows];

        function renderPage() {
            const total = filteredRows.length;
            const totalPages = Math.ceil(total / pageSize) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIdx = (currentPage - 1) * pageSize;
            const endIdx = startIdx + pageSize;

            // Hide all rows first
            rows.forEach(r => r.style.display = 'none');

            if (total === 0) {
                if (noMatchRow) noMatchRow.style.display = 'table-row';
                if (navEl) navEl.innerHTML = '';
                if (infoEl) infoEl.textContent = 'Tidak ada pertanyaan yang sesuai dengan filter.';
                return;
            } else {
                if (noMatchRow) noMatchRow.style.display = 'none';
            }

            // Show current page rows and update numbers
            filteredRows.forEach((row, idx) => {
                if (idx >= startIdx && idx < endIdx) {
                    row.style.display = 'table-row';
                    const numCol = row.querySelector('.top-row-num');
                    if (numCol) numCol.textContent = idx + 1;
                }
            });

            // Update Info text
            const actualEnd = Math.min(endIdx, total);
            if (total <= pageSize) {
                if (infoEl) infoEl.textContent = `Menampilkan ${total} pertanyaan`;
                if (navEl) navEl.innerHTML = '';
            } else {
                if (infoEl) infoEl.textContent = `Menampilkan ${startIdx + 1} - ${actualEnd} dari ${total} pertanyaan`;
                renderPaginationNav(totalPages);
            }
        }

        function renderPaginationNav(totalPages) {
            if (!navEl) return;
            let html = '';

            // Previous Button
            html += `<li class="page-item previous ${currentPage === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link py-1 px-2 fs-8" data-page="${currentPage - 1}">
                    <i class="previous"></i>
                </a>
            </li>`;

            // Page numbers
            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7) {
                    if (p > 1 && p < currentPage - 2 && p === 2) {
                        html += `<li class="page-item disabled"><span class="page-link py-1 px-2 fs-8">...</span></li>`;
                        continue;
                    }
                    if (p < totalPages && p > currentPage + 2 && p === totalPages - 1) {
                        html += `<li class="page-item disabled"><span class="page-link py-1 px-2 fs-8">...</span></li>`;
                        continue;
                    }
                    if (p !== 1 && p !== totalPages && (p < currentPage - 2 || p > currentPage + 2)) {
                        continue;
                    }
                }

                html += `<li class="page-item ${p === currentPage ? 'active' : ''}">
                    <a href="#" class="page-link py-1 px-2 fs-8" data-page="${p}">${p}</a>
                </li>`;
            }

            // Next Button
            html += `<li class="page-item next ${currentPage === totalPages ? 'disabled' : ''}">
                <a href="#" class="page-link py-1 px-2 fs-8" data-page="${currentPage + 1}">
                    <i class="next"></i>
                </a>
            </li>`;

            navEl.innerHTML = html;

            navEl.querySelectorAll('a.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetPage = parseInt(this.getAttribute('data-page'));
                    if (targetPage && targetPage !== currentPage && targetPage >= 1 && targetPage <= totalPages) {
                        currentPage = targetPage;
                        renderPage();
                    }
                });
            });
        }

        function applyFilter() {
            const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
            const sourceVal = filterSource ? filterSource.value : '';
            const feedbackVal = filterFeedback ? filterFeedback.value : '';

            const isFiltered = query.length > 0 || sourceVal !== '' || feedbackVal !== '';
            if (btnReset) btnReset.style.display = isFiltered ? 'inline-flex' : 'none';

            filteredRows = rows.filter(row => {
                const rSource = row.getAttribute('data-source') || '';
                const hasLike = row.getAttribute('data-has-like') === '1';
                const hasDislike = row.getAttribute('data-has-dislike') === '1';

                // Source match
                if (sourceVal && rSource !== sourceVal) {
                    return false;
                }

                // Feedback match
                if (feedbackVal === 'liked' && !hasLike) return false;
                if (feedbackVal === 'disliked' && !hasDislike) return false;
                if (feedbackVal === 'none' && (hasLike || hasDislike)) return false;

                // 100% Flexible Freetext match across entire row text + all data attributes
                if (query) {
                    const rowText = (row.textContent || '').toLowerCase().replace(/\s+/g, ' ');
                    const freqNum = row.getAttribute('data-freq') || '';
                    const extraData = [
                        row.getAttribute('data-question') || '',
                        row.getAttribute('data-solution') || '',
                        row.getAttribute('data-category') || '',
                        freqNum,
                        freqNum ? freqNum + 'x' : '',
                        freqNum ? freqNum + 'x ditanyakan' : '',
                        rSource === 'template' ? 'template db resmi' : 'pencarian sistem ai'
                    ].join(' ').toLowerCase();

                    const searchCorpus = rowText + ' ' + extraData;
                    const searchTerms = query.split(/\s+/).filter(t => t.length > 0);

                    const isMatch = searchTerms.every(term => searchCorpus.includes(term));
                    if (!isMatch) {
                        return false;
                    }
                }

                return true;
            });

            currentPage = 1;
            renderPage();

            if (statusText) {
                if (isFiltered) {
                    statusText.textContent = `Ditemukan: ${filteredRows.length} hasil`;
                } else {
                    statusText.textContent = '';
                }
            }
        }

        if (searchInput) searchInput.addEventListener('input', applyFilter);
        if (filterSource) filterSource.addEventListener('change', applyFilter);
        if (filterFeedback) filterFeedback.addEventListener('change', applyFilter);
        if (btnReset) {
            btnReset.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                if (filterSource) filterSource.value = '';
                if (filterFeedback) filterFeedback.value = '';
                applyFilter();
            });
        }

        // Initial render
        renderPage();
    })();

    // Inisialisasi kartu saat dokumen dimuat
    document.addEventListener('DOMContentLoaded', function() {
        updateSelectedKeyCard();
    });
</script>
@endsection
