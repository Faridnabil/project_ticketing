@extends('layouts.dashboard.app')

@section('title')
    Kelola FAQ | SIAK Dukcapil
@endsection

@section('content')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Kelola FAQ
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Bank Solusi Kendala</small>
            </h1>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-light-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalImportFaq">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Impor CSV
            </button>
            <button type="button" class="btn btn-sm btn-primary fw-bold" style="background-color: #002147; border: none;" data-bs-toggle="modal" data-bs-target="#modalAddFaq">
                <i class="bi bi-plus-lg me-1"></i> Tambah FAQ Baru
            </button>
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
                <div class="d-flex flex-column">
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center p-4 mb-5">
                <i class="bi bi-exclamation-triangle-fill fs-3 text-danger me-3"></i>
                <div class="d-flex flex-column">
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!--begin::Nav Tabs-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-6 fw-bold mb-5 gap-2">
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-3 active d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab_faq_templates">
                    <i class="bi bi-journal-check text-primary fs-4"></i>
                    <span>Daftar FAQ Resmi</span>
                    <span class="badge badge-light-primary fw-bolder fs-8 ms-1">{{ $faqs->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-danger pb-3 d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab_faq_unanswered">
                    <span>Antrean Pertanyaan Baru</span>
                    @if($unansweredCount > 0)
                        <span class="badge badge-danger fw-bolder fs-8 ms-1">{{ $unansweredCount }}</span>
                    @else
                        <span class="badge badge-light-success fw-bolder fs-8 ms-1">0</span>
                    @endif
                </a>
            </li>
        </ul>
        <!--end::Nav Tabs-->

        <div class="tab-content" id="faqTabsContent">
            <!-- ==================== TAB 1: EXISTING TEMPLATES ==================== -->
            <div class="tab-pane fade show active" id="tab_faq_templates" role="tabpanel">
                <div class="card card-flush shadow-sm">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fs-7 fw-bold text-gray-700">Filter Kategori:</span>
                                <select id="faqCategoryFilter" class="form-select form-select-sm form-select-solid w-200px fs-7">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <table id="kt_datatable_faq" class="table table-row-bordered gy-5 align-middle">
                            <thead>
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-160px">Pertanyaan</th>
                                    <th class="min-w-220px">Jawaban</th>
                                    <th class="min-w-100px">Kategori</th>
                                    <th class="min-w-100px">Kata Kunci</th>
                                    <th class="min-w-60px text-center">Status</th>
                                    <th class="min-w-80px text-end pe-3">Fitur</th>
                                </tr>
                            </thead>
                            <tbody class="text-black-600 fw-bold fs-7">
                                @foreach($faqs as $faq)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-bolder text-dark fs-7">{{ $faq->question }}</div>
                                            <small class="text-muted fs-8">Dibuat: {{ $faq->created_at ? $faq->created_at->format('d M Y') : '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="text-gray-700 fs-8" style="max-height: 48px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" title="{{ $faq->answer }}">
                                                {{ Str::limit(strip_tags($faq->answer), 140) }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary fw-bold">{{ $faq->category }}</span>
                                        </td>
                                        <td>
                                            @if($faq->keywords)
                                                @foreach(array_slice(explode(',', $faq->keywords), 0, 3) as $kw)
                                                    <span class="badge badge-light-dark fs-9 p-1 px-2 mb-1">{{ trim($kw) }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted fs-9">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('admin.faq.toggle', $faq->id) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="badge {{ $faq->is_active ? 'badge-success' : 'badge-danger' }} border-0 py-1 px-2 cursor-pointer" title="Klik untuk mengubah status">
                                                    {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end pe-3 text-nowrap">
                                            <button type="button" class="btn btn-icon btn-light-primary btn-sm me-1" onclick="openShowFaqModal({{ json_encode($faq) }})" title="Lihat Detail Solusi FAQ Lengkap">
                                                <i class="bi bi-eye-fill fs-6"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-light-warning btn-sm me-1" onclick="openEditModal({{ json_encode($faq) }})" title="Edit FAQ">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.faq.destroy', $faq->id) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data FAQ ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-light-danger btn-sm" title="Hapus FAQ">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==================== TAB 2: UNANSWERED QUESTIONS QUEUE ==================== -->
            <div class="tab-pane fade" id="tab_faq_unanswered" role="tabpanel">
                <div class="card card-flush shadow-sm">
                    <div class="card-header pt-5 pb-3">
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between w-100 gap-3">
                            <div>
                                <h3 class="card-title align-items-start flex-column m-0">
                                    <span class="card-label fw-bolder fs-5 text-dark">Pertanyaan Pengguna Menunggu Dijadikan FAQ Resmi</span>
                                    <span class="text-muted mt-1 fw-bold fs-7 mt-3">Pertanyaan relevan seputar Dukcapil & SIAK yang dijawab otomatis oleh sistem dan dapat dijadikan FAQ resmi</span>
                                    <br>
                                </h3>
                            </div>
                            <span class="badge badge-light-danger fw-bold fs-8" id="badgeUnansweredTotal">
                                <span id="unansweredCountBadgeText">{{ $unansweredCount }}</span> Pertanyaan Menunggu
                            </span>
                        </div>

                        <!-- Filter & Search Toolbar (Sejajar / Inline & Compact) -->
                        <div class="d-flex align-items-center flex-wrap gap-3 pt-3 mt-2 border-top border-gray-200">
                            <div class="position-relative" style="width: 280px; min-width: 200px;">
                                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" id="searchUnansweredQueue" class="form-control form-control-sm form-control-solid ps-9 fs-7" placeholder="Cari pertanyaan, frekuensi (1x), draft...">
                            </div>
                            <div style="width: 180px;">
                                <select id="filterUnansweredFreq" class="form-select form-select-sm form-select-solid fs-7">
                                    <option value="">Semua Frekuensi</option>
                                    <option value="frequent">Sering Ditanyakan (&gt; 1x)</option>
                                    <option value="single">1x Ditanyakan</option>
                                </select>
                            </div>
                            <button type="button" id="btnResetUnansweredFilter" class="btn btn-sm btn-light fs-8 text-nowrap" style="display: none;">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                            </button>
                            <div class="text-muted fs-8 ms-auto" id="unansweredFilterStatusText"></div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-7 gy-4" id="tableUnansweredQueue">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-8 text-uppercase gs-0">
                                        <th class="w-50px">No</th>
                                        <th class="min-w-200px">Pertanyaan Pengguna</th>
                                        <th class="min-w-80px text-center">Frekuensi</th>
                                        <th class="min-w-250px">Draft Solusi Sistem</th>
                                        <th class="min-w-120px">Terakhir Ditanyakan</th>
                                        <th class="text-end min-w-185px text-nowrap pe-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 fw-semibold" id="tbodyUnansweredQueue">
                                    @forelse($unansweredQuestions as $index => $item)
                                        @php
                                            $primaryUser = $item->last_user ?: ($item->related_users->first() ?? null);
                                            $primaryUserName = $primaryUser ? $primaryUser->name : 'Pengguna Portal';
                                            $allUserNames = ($item->related_users && count($item->related_users) > 0)
                                                ? collect($item->related_users)->pluck('name')->implode(', ')
                                                : $primaryUserName;
                                        @endphp
                                        <tr class="unanswered-row"
                                            data-question="{{ strtolower(e($item->question)) }}"
                                            data-draft="{{ strtolower(e($item->ai_draft_answer ?? '')) }}"
                                            data-user="{{ strtolower(e($allUserNames)) }}"
                                            data-freq="{{ (int) $item->occurrence_count }}">
                                            <td class="unanswered-row-num">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="text-dark fw-bold fs-7">{{ $item->question }}</div>
                                                <div class="text-muted fs-8 mt-1 d-flex align-items-center gap-1">
                                                    <i class="bi bi-person-circle text-primary fs-8"></i>
                                                    <span>Penanya: <strong class="text-gray-800">{{ $primaryUserName }}</strong></span>
                                                    @if(count($item->related_users ?? []) > 1)
                                                        <span class="badge badge-light-secondary fs-9 py-0 px-1 cursor-pointer" title="{{ $allUserNames }}">+{{ count($item->related_users) - 1 }} lainnya</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-light-danger fw-bolder">{{ $item->occurrence_count }}x ditanyakan</span>
                                            </td>
                                            <td>
                                                <div class="text-gray-600 fs-8 text-truncate-2" style="max-height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" title="{{ $item->ai_draft_answer }}">
                                                    {{ Str::limit($item->ai_draft_answer ?: 'Belum ada draft jawaban', 130) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-8">{{ $item->updated_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="text-end text-nowrap pe-3">
                                                <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="openShowUnansweredModal({{ json_encode($item) }})" title="Lihat Detail Pertanyaan & Draft Solusi" style="width: 32px; height: 32px;">
                                                        <i class="bi bi-eye-fill fs-6"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light-success fw-bold fs-8 d-inline-flex align-items-center gap-1 text-nowrap py-2 px-3" onclick="openConvertModal({{ json_encode($item) }})">
                                                        <i class="bi bi-plus-circle fs-7"></i>
                                                        <span>Jadikan FAQ</span>
                                                    </button>
                                                    <form action="{{ route('admin.faq.delete_unanswered', $item->id) }}" method="POST" class="d-inline m-0 p-0" onsubmit="return confirm('Hapus pertanyaan ini dari antrean?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-icon btn-light-danger" title="Hapus dari antrean" style="width: 32px; height: 32px;">
                                                            <i class="bi bi-trash fs-6"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="emptyUnansweredQueueRow">
                                            <td colspan="6" class="text-center py-10 text-muted">
                                                <i class="bi bi-patch-check-fill text-success fs-2x mb-3 d-block"></i>
                                                <div class="fw-bolder fs-5 text-dark">Semua Pertanyaan Relevan Sudah Memiliki FAQ Resmi!</div>
                                                <div class="text-muted fs-7 mt-1">Belum ada pertanyaan baru seputar Dukcapil & SIAK yang diajukan oleh pengguna.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    <tr id="noMatchUnansweredQueueRow" style="display: none;">
                                        <td colspan="6" class="text-center py-8 text-muted fs-7">
                                            <i class="bi bi-search fs-2 d-block mb-2 text-muted"></i>
                                            Tidak ditemukan pertanyaan yang cocok dengan filter pencarian.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer (Shows controls if > 10 data) -->
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pt-4 border-top gap-3" id="unansweredPaginationWrapper">
                            <div class="text-muted fs-8" id="unansweredPaginationInfo">
                                Menampilkan {{ $unansweredCount }} pertanyaan
                            </div>
                            <ul class="pagination pagination-sm m-0" id="unansweredPaginationNav">
                                <!-- Dynamic Pagination buttons -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Post-->

<!--begin::Modal Add FAQ-->
<div class="modal fade" id="modalAddFaq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.faq.store') }}">
                @csrf
                <div class="modal-header" style="background:#002147; color:#fff;">
                    <h5 class="modal-title text-white"><i class="bi bi-plus-circle me-2 text-warning"></i>Tambah FAQ Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Pertanyaan:</label>
                        <input type="text" name="question" class="form-control form-control-solid fs-7" placeholder="Contoh: Bagaimana cara reset password SIAK?" required />
                    </div>
                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Jawaban Solusi:</label>
                        <textarea name="answer" rows="5" class="form-control form-control-solid fs-7" placeholder="Tuliskan langkah-langkah solusi lengkap (dapat menggunakan format **teks tebal**)..." required></textarea>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="required form-label fw-bold fs-7">Kategori:</label>
                            <input type="text" name="category" class="form-control form-control-solid fs-7" placeholder="Pilih atau ketik kategori..." list="categoryOptions" required />
                            <datalist id="categoryOptions">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                            <small class="text-muted fs-9 mt-1 d-block">Pilih kategori resmi (SIAK Terpusat, Jarkomdat, IKD, dll.) atau ketik baru.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Kata Kunci (Keywords):</label>
                            <input type="text" name="keywords" class="form-control form-control-solid fs-7" placeholder="Contoh: login, password, reset, akun, siak" />
                            <small class="text-muted fs-9 mt-1 d-block">Pisahkan dengan koma untuk mempermudah pencarian Sistem.</small>
                        </div>
                    </div>
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="addIsActive" checked />
                        <label class="form-check-label fw-bold fs-7" for="addIsActive">
                            Aktifkan langsung di Chat Assistant
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold" style="background:#002147; border:none;">Simpan FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Add FAQ-->

<!--begin::Modal Convert Unanswered to FAQ-->
<div class="modal fade" id="modalConvertUnanswered" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.faq.convert') }}" method="POST">
                @csrf
                <input type="hidden" name="unanswered_id" id="convertUnansweredId" />
                <div class="modal-header" style="background:#002147; color:#fff;">
                    <h5 class="modal-title text-white"><i class="bi bi-magic me-2 text-warning"></i>Jadikan FAQ Resmi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <div class="alert alert-light-primary p-3 mb-4 fs-8">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i>
                        Pertanyaan pengguna dan draft solusi telah disiapkan di bawah. Anda dapat menyempurnakan jawaban sebelum disimpan sebagai FAQ resmi.
                    </div>
                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Pertanyaan:</label>
                        <input type="text" name="question" id="convertQuestion" class="form-control form-control-solid fs-7" required />
                    </div>
                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Jawaban Solusi:</label>
                        <textarea name="answer" id="convertAnswer" rows="6" class="form-control form-control-solid fs-7" required></textarea>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="required form-label fw-bold fs-7">Kategori:</label>
                            <input type="text" name="category" id="convertCategory" class="form-control form-control-solid fs-7" placeholder="Pilih atau ketik kategori..." list="categoryOptions" required />
                            <small class="text-muted fs-9 mt-1 d-block">Pilih kategori resmi (SIAK Terpusat, Jarkomdat, IKD, dll.) atau ketik baru.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Kata Kunci (Keywords):</label>
                            <input type="text" name="keywords" id="convertKeywords" class="form-control form-control-solid fs-7" placeholder="Contoh: login, password, reset, akun" />
                            <small class="text-muted fs-9 mt-1 d-block">Pisahkan dengan koma.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold">
                        <i class="bi bi-check-circle me-1"></i> Simpan Sebagai FAQ Resmi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Convert Unanswered to FAQ-->

<!--begin::Modal Edit FAQ-->
<div class="modal fade" id="modalEditFaq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editFaqForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="background:#002147; color:#fff;">
                    <h5 class="modal-title text-white"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit FAQ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Pertanyaan:</label>
                        <input type="text" id="editQuestion" name="question" class="form-control form-control-solid fs-7" required />
                    </div>
                    <div class="mb-4">
                        <label class="required form-label fw-bold fs-7">Jawaban Solusi:</label>
                        <textarea id="editAnswer" name="answer" rows="5" class="form-control form-control-solid fs-7" required></textarea>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="required form-label fw-bold fs-7">Kategori:</label>
                            <input type="text" id="editCategory" name="category" class="form-control form-control-solid fs-7" placeholder="Pilih atau ketik kategori..." list="categoryOptions" required />
                            <small class="text-muted fs-9 mt-1 d-block">Pilih kategori resmi atau ketik baru.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">Kata Kunci (Keywords):</label>
                            <input type="text" id="editKeywords" name="keywords" class="form-control form-control-solid fs-7" placeholder="Contoh: login, password, reset, akun" />
                            <small class="text-muted fs-9 mt-1 d-block">Pisahkan dengan koma.</small>
                        </div>
                    </div>
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="editIsActive" />
                        <label class="form-check-label fw-bold fs-7" for="editIsActive">
                            Aktifkan di Chat Assistant
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold" style="background:#002147; border:none;">Perbarui FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Edit FAQ-->

<!--begin::Modal Import Excel / CSV-->
<div class="modal fade" id="modalImportFaq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.faq.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#002147; color:#fff;">
                    <h5 class="modal-title text-white"><i class="bi bi-file-earmark-excel me-2 text-warning fs-4"></i>Impor FAQ dari Berkas Excel / CSV</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <div class="alert alert-light-primary p-4 mb-5 border border-primary border-opacity-25 rounded-3">
                        <div class="fw-bold fs-7 text-primary mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle-fill text-primary fs-5"></i> Format Kolom Excel & CSV
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center fs-8 mb-0 bg-white">
                                <thead class="bg-light fw-bold text-dark">
                                    <tr>
                                        <th class="py-2">Kolom A</th>
                                        <th class="py-2">Kolom B</th>
                                        <th class="py-2">Kolom C</th>
                                        <th class="py-2">Kolom D</th>
                                    </tr>
                                    <tr class="text-primary">
                                        <th>Pertanyaan</th>
                                        <th>Jawaban Solusi</th>
                                        <th>Kategori</th>
                                        <th>Kata Kunci</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600">
                                    <tr>
                                        <td class="text-start">Cara mengatasi gagal login SIAK?</td>
                                        <td class="text-start">Buka portal SIAK Terpusat lalu klik Lupa Password...</td>
                                        <td><span class="badge badge-light-primary">Aplikasi SIAK Terpusat</span></td>
                                        <td>login, password, reset, siak</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="required form-label fw-bold fs-7">Pilih Berkas Excel / CSV:</label>
                        <input type="file" name="file" class="form-control form-control-solid fs-7" accept=".xlsx,.xls,.csv" required />
                        <small class="text-muted fs-9 mt-1 d-block">Mendukung Microsoft Excel (<code>.xlsx</code>, <code>.xls</code>) dan CSV (<code>.csv</code>).</small>
                    </div>

                    <div class="card bg-light-secondary border border-gray-200 p-4 rounded-3">
                        <div class="fw-bold fs-8 text-dark mb-2 d-flex align-items-center gap-1">
                            <i class="bi bi-cloud-arrow-down-fill text-success fs-5"></i> Unduh Berkas Contoh Template Resmi:
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <a href="{{ route('admin.faq.template', ['format' => 'xlsx']) }}" class="btn btn-sm btn-success fw-bold">
                                <i class="bi bi-file-earmark-excel-fill me-1"></i> Unduh Format Excel (.xlsx)
                            </a>
                            <a href="{{ route('admin.faq.template', ['format' => 'csv']) }}" class="btn btn-sm btn-light-primary fw-bold">
                                <i class="bi bi-file-earmark-text-fill me-1"></i> Unduh Format CSV (.csv)
                            </a>
                        </div>
                        <small class="text-muted fs-9 mt-2">
                            *Format Excel (.xlsx) sudah dilengkapi sheet panduan daftar kategori resmi Dukcapil SIAK.
                        </small>
                    </div>
                </div>
                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light fw-bold btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold btn-sm">
                        <i class="bi bi-upload me-1"></i> Unggah & Impor Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ==================== MODAL: SHOW DETAIL FAQ RESMI ==================== -->
<div class="modal fade" id="modalShowFaqDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content border-0 shadow">
            <div class="modal-header py-4 px-6" style="background-color: #002147;">
                <h3 class="modal-title text-white fw-bolder d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-text-fill text-warning fs-3"></i> Detail Solusi FAQ Resmi
                </h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary text-white" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-2"></i>
                </div>
            </div>

            <div class="modal-body p-6">
                <!-- Question Card -->
                <div class="card bg-light-primary border border-primary border-opacity-25 rounded p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <span class="fs-8 fw-bold text-uppercase text-muted">Pertanyaan Resmi:</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge badge-light-primary fw-bolder fs-8" id="showFaqCategoryBadge"></span>
                            <span class="badge fs-8 fw-bold" id="showFaqStatusBadge"></span>
                        </div>
                    </div>
                    <div class="fw-bolder text-dark fs-5" id="showFaqQuestion"></div>
                </div>

                <!-- Solution Card -->
                <div class="card border border-gray-200 rounded p-4 mb-4 bg-white shadow-xs">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <span class="fs-8 fw-bold text-uppercase text-dark d-flex align-items-center gap-1">
                            <i class="bi bi-patch-check-fill text-success fs-6"></i> Jawaban / Solusi Terverifikasi:
                        </span>
                        <span class="badge badge-success fs-9 fw-bold">● Terverifikasi Kedinasan</span>
                    </div>
                    <div class="text-gray-800 fs-7 lh-base" id="showFaqAnswer" style="white-space: pre-wrap; word-break: break-word;"></div>
                </div>

                <!-- Meta Info Grid -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border border-gray-200 rounded p-3 h-100 bg-light" style="background: #f8fafc;">
                            <span class="fs-8 fw-bold text-uppercase text-muted d-block mb-2">
                                <i class="bi bi-tags-fill text-primary me-1"></i> Kata Kunci (Keywords):
                            </span>
                            <div id="showFaqKeywords" class="d-flex flex-wrap gap-1"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border border-gray-200 rounded p-3 h-100 bg-light" style="background: #f8fafc;">
                            <span class="fs-8 fw-bold text-uppercase text-muted d-block mb-2">
                                <i class="bi bi-clock-history text-primary me-1"></i> Riwayat Pencatatan:
                            </span>
                            <div class="fs-8 text-gray-700 d-flex flex-column gap-1">
                                <div>Dibuat Pada: <strong id="showFaqCreatedAt">-</strong></div>
                                <div>Dibuat Oleh: <strong id="showFaqCreatedBy">-</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer py-3 px-6 bg-light d-flex justify-content-between">
                <button type="button" class="btn btn-warning btn-sm fw-bold" id="btnEditFromShowModal">
                    <i class="bi bi-pencil-square me-1"></i> Edit FAQ Ini
                </button>
                <button type="button" class="btn btn-light btn-sm fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL: SHOW DETAIL PERTANYAAN MENUNGGU ==================== -->
<div class="modal fade" id="modalShowUnansweredDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content border-0 shadow">
            <div class="modal-header py-4 px-6" style="background-color: #002147;">
                <h3 class="modal-title text-white fw-bolder d-flex align-items-center gap-2">
                    <i class="bi bi-chat-square-text-fill text-warning fs-3"></i> Detail Pertanyaan Menunggu & Draft Solusi AI
                </h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary text-white" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-2"></i>
                </div>
            </div>

            <div class="modal-body p-6">
                <!-- Question Card -->
                <div class="card bg-light-danger border border-danger border-opacity-25 rounded p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <span class="fs-8 fw-bold text-uppercase text-danger">Pertanyaan Pengguna:</span>
                        <span class="badge badge-danger fw-bolder fs-8" id="showUnansweredFreqBadge"></span>
                    </div>
                    <div class="fw-bolder text-dark fs-5" id="showUnansweredQuestion"></div>
                </div>

                <!-- AI Draft Solution Card -->
                <div class="card border border-gray-200 rounded p-4 mb-4 bg-white shadow-xs">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <span class="fs-8 fw-bold text-uppercase text-dark d-flex align-items-center gap-1">
                            <i class="bi bi-robot text-info fs-6"></i> Draft Solusi Sistem (AI Gemini):
                        </span>
                        <span class="badge badge-light-info fs-9 fw-bold">Dihasilkan Otomatis oleh AI</span>
                    </div>
                    <div class="text-gray-800 fs-7 lh-base" id="showUnansweredDraft" style="white-space: pre-wrap; word-break: break-word;"></div>
                </div>

                <!-- User Penanya and Time -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border border-gray-200 rounded p-3 h-100 bg-light" style="background: #f8fafc;">
                            <span class="fs-8 fw-bold text-uppercase text-muted d-block mb-2">
                                <i class="bi bi-person-circle text-primary me-1"></i> User yang Bertanya:
                            </span>
                            <div id="showUnansweredUser" class="d-flex align-items-center gap-2"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border border-gray-200 rounded p-3 h-100 bg-light" style="background: #f8fafc;">
                            <span class="fs-8 fw-bold text-uppercase text-muted d-block mb-2">
                                <i class="bi bi-clock-history text-primary me-1"></i> Terakhir Ditanyakan:
                            </span>
                            <div class="fs-8 text-gray-700">
                                <strong id="showUnansweredTime">-</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer py-3 px-6 bg-light d-flex justify-content-between">
                <button type="button" class="btn btn-success btn-sm fw-bold" id="btnConvertFromShowModal">
                    <i class="bi bi-plus-circle me-1"></i> Jadikan FAQ Resmi Sekarang
                </button>
                <button type="button" class="btn btn-light btn-sm fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal Show Detail-->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var tableFaq = $("#kt_datatable_faq").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
                "emptyTable": "Tidak ada data FAQ yang ditampilkan."
            },
            "dom": "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +
                "<'table-responsive'tr>" +
                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">",
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
            "order": [[0, 'asc']],
            "columnDefs": [
                { targets: [6], orderable: false }
            ]
        });

        $('#faqCategoryFilter').on('change', function() {
            var val = $(this).val();
            tableFaq.column(3).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
        });
    });

    function openEditModal(faq) {
        document.getElementById('editFaqForm').action = "/admin/faqs/" + faq.id;
        document.getElementById('editQuestion').value = faq.question;
        document.getElementById('editAnswer').value = faq.answer;
        document.getElementById('editCategory').value = faq.category || 'Umum';
        document.getElementById('editKeywords').value = faq.keywords || '';
        document.getElementById('editIsActive').checked = faq.is_active;

        new bootstrap.Modal(document.getElementById('modalEditFaq')).show();
    }

    function openConvertModal(item) {
        document.getElementById('convertUnansweredId').value = item.id;
        document.getElementById('convertQuestion').value = item.question;
        document.getElementById('convertAnswer').value = item.ai_draft_answer || '';
        document.getElementById('convertCategory').value = 'Aplikasi SIAK Terpusat';
        document.getElementById('convertKeywords').value = '';

        new bootstrap.Modal(document.getElementById('modalConvertUnanswered')).show();
    }

    // ==========================================
    // SHOW DETAIL FAQ RESMI (TAB 1)
    // ==========================================
    let currentFaqForEdit = null;
    function openShowFaqModal(faq) {
        currentFaqForEdit = faq;
        document.getElementById('showFaqQuestion').textContent = faq.question;
        document.getElementById('showFaqAnswer').innerHTML = formatFaqTextToHtml(faq.answer);
        document.getElementById('showFaqCategoryBadge').textContent = faq.category || 'Umum';
        
        const statusBadge = document.getElementById('showFaqStatusBadge');
        if (faq.is_active) {
            statusBadge.className = 'badge badge-success fw-bold fs-8';
            statusBadge.textContent = '● Aktif';
        } else {
            statusBadge.className = 'badge badge-danger fw-bold fs-8';
            statusBadge.textContent = '● Nonaktif';
        }

        // Keywords
        const kwContainer = document.getElementById('showFaqKeywords');
        if (faq.keywords) {
            const list = faq.keywords.split(',').map(s => s.trim()).filter(Boolean);
            kwContainer.innerHTML = list.map(kw => `<span class="badge badge-light-primary fs-8 px-2 py-1">${escapeFaqHtml(kw)}</span>`).join('');
        } else {
            kwContainer.innerHTML = '<span class="text-muted fs-8">Tidak ada kata kunci khusus</span>';
        }

        // Created Info
        document.getElementById('showFaqCreatedAt').textContent = faq.created_at ? new Date(faq.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';
        document.getElementById('showFaqCreatedBy').textContent = faq.creator ? faq.creator.name : 'Administrator';

        const modalEl = document.getElementById('modalShowFaqDetail');
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.show();
    }

    document.getElementById('btnEditFromShowModal')?.addEventListener('click', function() {
        const modalEl = document.getElementById('modalShowFaqDetail');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        if (currentFaqForEdit) {
            openEditModal(currentFaqForEdit);
        }
    });

    // ==========================================
    // SHOW DETAIL PERTANYAAN MENUNGGU (TAB 2)
    // ==========================================
    let currentUnansweredForConvert = null;
    function openShowUnansweredModal(item) {
        currentUnansweredForConvert = item;
        document.getElementById('showUnansweredQuestion').textContent = item.question;
        document.getElementById('showUnansweredDraft').innerHTML = formatFaqTextToHtml(item.ai_draft_answer || 'Belum ada draf solusi sistem.');
        document.getElementById('showUnansweredFreqBadge').textContent = (item.occurrence_count || 1) + 'x Ditanyakan';

        const primaryUser = item.last_user || (item.related_users && item.related_users[0] ? item.related_users[0] : null);
        const primaryName = primaryUser ? primaryUser.name : 'Pengguna Portal';
        const primaryEmail = primaryUser ? (primaryUser.email || primaryUser.nik || 'Pengguna Aplikasi') : 'Pengguna Portal Terdaftar';

        document.getElementById('showUnansweredUser').innerHTML = `
            <div class="symbol symbol-30px symbol-circle">
                <span class="symbol-label bg-light-primary text-primary fw-bolder fs-7">
                    ${escapeFaqHtml(primaryName.charAt(0).toUpperCase())}
                </span>
            </div>
            <div class="d-flex flex-column">
                <span class="text-dark fw-bold fs-7">${escapeFaqHtml(primaryName)}</span>
                <span class="text-muted fs-8">${escapeFaqHtml(primaryEmail)}</span>
            </div>
        `;

        document.getElementById('showUnansweredTime').textContent = item.updated_at ? new Date(item.updated_at).toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) + ' WIB' : '-';

        const modalEl = document.getElementById('modalShowUnansweredDetail');
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.show();
    }

    document.getElementById('btnConvertFromShowModal')?.addEventListener('click', function() {
        const modalEl = document.getElementById('modalShowUnansweredDetail');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        if (currentUnansweredForConvert) {
            openConvertModal(currentUnansweredForConvert);
        }
    });

    function escapeFaqHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.toString().replace(/[&<>"']/g, m => map[m]);
    }

    function formatFaqTextToHtml(text) {
        if (!text) return '<span class="text-muted">Tidak ada catatan solusi tersimpan.</span>';
        let safe = escapeFaqHtml(text);
        safe = safe.replace(/\*\*(.*?)\*\*/g, '<strong class="text-dark">$1</strong>');
        safe = safe.replace(/\n/g, '<br>');
        return safe;
    }

    // ==========================================
    // UNANSWERED QUESTIONS QUEUE: SEARCH, FILTER & PAGINATION (10 per page)
    // ==========================================
    (function initUnansweredQueueTable() {
        const searchInput = document.getElementById('searchUnansweredQueue');
        const filterFreq = document.getElementById('filterUnansweredFreq');
        const btnReset = document.getElementById('btnResetUnansweredFilter');
        const statusText = document.getElementById('unansweredFilterStatusText');
        const countBadge = document.getElementById('unansweredCountBadgeText');
        const navEl = document.getElementById('unansweredPaginationNav');
        const infoEl = document.getElementById('unansweredPaginationInfo');
        const noMatchRow = document.getElementById('noMatchUnansweredQueueRow');
        const rows = Array.from(document.querySelectorAll('#tbodyUnansweredQueue .unanswered-row'));

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

            rows.forEach(r => r.style.display = 'none');

            if (total === 0) {
                if (noMatchRow) noMatchRow.style.display = 'table-row';
                if (navEl) navEl.innerHTML = '';
                if (infoEl) infoEl.textContent = 'Tidak ada pertanyaan yang sesuai dengan filter.';
                return;
            } else {
                if (noMatchRow) noMatchRow.style.display = 'none';
            }

            filteredRows.forEach((row, idx) => {
                if (idx >= startIdx && idx < endIdx) {
                    row.style.display = 'table-row';
                    const numCol = row.querySelector('.unanswered-row-num');
                    if (numCol) numCol.textContent = idx + 1;
                }
            });

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

            html += `<li class="page-item previous ${currentPage === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link py-1 px-2 fs-8" data-page="${currentPage - 1}">
                    <i class="previous"></i>
                </a>
            </li>`;

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
            const freqVal = filterFreq ? filterFreq.value : '';

            const isFiltered = query.length > 0 || freqVal !== '';
            if (btnReset) btnReset.style.display = isFiltered ? 'inline-flex' : 'none';

            filteredRows = rows.filter(row => {
                const freq = parseInt(row.getAttribute('data-freq') || '1');

                // Filter Frekuensi dropdown
                if (freqVal === 'frequent' && freq <= 1) return false;
                if (freqVal === 'single' && freq !== 1) return false;

                // 100% Flexible Freetext match across entire row text + all data attributes
                if (query) {
                    const rowText = (row.textContent || '').toLowerCase().replace(/\s+/g, ' ');
                    const freqNum = row.getAttribute('data-freq') || '';
                    const extraData = [
                        row.getAttribute('data-question') || '',
                        row.getAttribute('data-draft') || '',
                        row.getAttribute('data-user') || '',
                        freqNum,
                        freqNum ? freqNum + 'x' : '',
                        freqNum ? freqNum + 'x ditanyakan' : ''
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
        if (filterFreq) filterFreq.addEventListener('change', applyFilter);
        if (btnReset) {
            btnReset.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                if (filterFreq) filterFreq.value = '';
                applyFilter();
            });
        }

        // Initial render
        renderPage();
    })();
</script>
@endsection
