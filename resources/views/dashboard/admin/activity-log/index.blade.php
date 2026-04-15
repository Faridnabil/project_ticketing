@extends('layouts.dashboard.app')

@section('title')
    Activity Log | SIAK Dukcapil
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Activity Log
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Timeline Aktivitas Pengguna</small>
                </h1>
            </div>
            <!-- <a href="{{ route('admin.activityLog.shift') }}" class="btn btn-sm btn-light-primary">
                <i class="bi bi-clock-history me-1"></i> Monitoring Shift
            </a> -->
        </div>
    </div>
    <!--end::Toolbar-->

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">

            {{-- Filter Card --}}
            <div class="card mb-5">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title fw-bolder fs-5">Filter</h3>
                </div>
                <div class="card-body pt-0">
                    <form method="GET" action="{{ route('admin.activityLog.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Pengguna</label>
                                <select name="user_id" class="form-select form-select-solid">
                                    <option value="">-- Semua Pengguna --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control form-control-solid"
                                    value="{{ request('tanggal_mulai') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control form-control-solid"
                                    value="{{ request('tanggal_selesai') }}">
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.activityLog.index') }}" class="btn btn-light w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Timeline --}}
            @if (!$hasFilter)
                <div class="card">
                    <div class="card-body text-center text-muted py-15">
                        <i class="bi bi-funnel fs-2x d-block mb-3"></i>
                        <div class="fw-semibold fs-6">Gunakan filter di atas untuk menelusuri log aktivitas.</div>
                    </div>
                </div>
            @elseif ($timeline->isEmpty())
                <div class="card">
                    <div class="card-body text-center text-muted py-15">
                        <i class="bi bi-inbox fs-2x d-block mb-3"></i>
                        Tidak ada aktivitas yang sesuai dengan filter.
                    </div>
                </div>
            @else
                @foreach ($timeline as $tanggal => $entries)
                    {{-- Date separator --}}
                    <div class="d-flex align-items-center mb-4 mt-2">
                        <div class="flex-grow-1 border-top border-2 border-gray-300"></div>
                        <span class="mx-4 badge badge-light-dark fw-bold fs-7 px-4 py-2">
                            <i class="bi bi-calendar3 me-1"></i>{{ $tanggal }}
                        </span>
                        <div class="flex-grow-1 border-top border-2 border-gray-300"></div>
                    </div>

                    {{-- Timeline entries for this date --}}
                    <div class="card mb-4">
                        <div class="card-body py-6 px-8">
                            <div class="timeline">
                                @foreach ($entries as $log)
                                    @php
                                        $attr     = $log->attribute;
                                        $noTicket = $tickets[$log->model_id] ?? ('#' . $log->model_id);
                                        $time     = \Carbon\Carbon::parse($log->created_at)->format('H:i:s');
                                        $userName = $log->user->name ?? 'System';
                                        $userRole = $log->user?->getRoleNames()->first() ?? '';

                                        // Label & warna berdasarkan attribute
                                        [$label, $badgeClass, $icon] = match (true) {
                                            $attr === 'CREATE_TICKET'           => ['BUAT TIKET',     'badge-light-success',  'bi-plus-circle-fill'],
                                            $attr === 'ADD_COMMENT'             => ['TAMBAH KOMENTAR','badge-light-info',     'bi-chat-left-text-fill'],
                                            $attr === 'status_id'               => ['UPDATE STATUS',  'badge-light-warning',  'bi-arrow-repeat'],
                                            $attr === 'priority_id'             => ['UBAH PRIORITAS', 'badge-light-danger',   'bi-exclamation-circle-fill'],
                                            $attr === 'category_id'             => ['UBAH KATEGORI',  'badge-light-primary',  'bi-tag-fill'],
                                            $attr === 'province_id'             => ['UPDATE PROVINSI', 'badge-light-primary',  'bi-map-fill'],
                                            $attr === 'city_or_regency_id'      => ['UPDATE KAB/KOTA', 'badge-light-primary',  'bi-pin-map-fill'],
                                            $attr === 'attachments'             => ['UPDATE LAMPIRAN', 'badge-light-info',     'bi-paperclip'],
                                            in_array($attr, ['level1','level2','level3','level4','level5'])
                                                                                => ['DISPOSISI',       'badge-light-dark',     'bi-person-check-fill'],
                                            $attr === 'completion_notes'        => ['CATATAN SELESAI','badge-light-success',  'bi-check2-all'],
                                            default                             => ['UPDATE: ' . strtoupper($attr), 'badge-dark',            'bi-pencil-fill'],
                                        };

                                        // Resolve FK IDs for province and city_or_regency
                                        $oldVal = $log->old_value;
                                        $newVal = $log->new_value;

                                        if ($attr === 'province_id') {
                                            $oldVal = \App\Models\Province::find($oldVal)?->province_name ?? $oldVal;
                                            $newVal = \App\Models\Province::find($newVal)?->province_name ?? $newVal;
                                        } elseif ($attr === 'city_or_regency_id') {
                                            $oldVal = \App\Models\CityOrRegency::find($oldVal)?->city_or_regency_name ?? $oldVal;
                                            $newVal = \App\Models\CityOrRegency::find($newVal)?->city_or_regency_name ?? $newVal;
                                        } elseif ($attr === 'status_id') {
                                            $oldVal = \App\Models\Status::find($oldVal)?->status_name ?? $oldVal;
                                            $newVal = \App\Models\Status::find($newVal)?->status_name ?? $newVal;
                                        } elseif ($attr === 'priority_id') {
                                            $oldVal = \App\Models\Priority::find($oldVal)?->priority_name ?? $oldVal;
                                            $newVal = \App\Models\Priority::find($newVal)?->priority_name ?? $newVal;
                                        } elseif ($attr === 'category_id') {
                                            $oldVal = \App\Models\Category::find($oldVal)?->category_name ?? $oldVal;
                                            $newVal = \App\Models\Category::find($newVal)?->category_name ?? $newVal;
                                        } elseif ($attr === 'attachments') {
                                            $oldArr = is_string($oldVal) ? json_decode($oldVal, true) : [];
                                            $newArr = is_string($newVal) ? json_decode($newVal, true) : [];
                                            
                                            $oldArr = is_array($oldArr) ? $oldArr : [];
                                            $newArr = is_array($newArr) ? $newArr : [];

                                            $oldCount = count($oldArr);
                                            $newCount = count($newArr);
                                            
                                            $added = count(array_diff($newArr, $oldArr));
                                            $removed = count(array_diff($oldArr, $newArr));
                                            
                                            $details = [];
                                            if ($added > 0) $details[] = "<span class='text-success'>+{$added}</span>";
                                            if ($removed > 0) $details[] = "<span class='text-danger'>-{$removed}</span>";
                                            
                                            $oldVal = "{$oldCount} lampiran";
                                            $newVal = "{$newCount} lampiran" . (!empty($details) ? " (" . implode(', ', $details) . ")" : "");
                                        }

                                        // Teks deskripsi singkat
                                        $desc = match (true) {
                                            $attr === 'CREATE_TICKET'  => "Tiket <strong>{$noTicket}</strong> berhasil dibuat.",
                                            $attr === 'ADD_COMMENT'    => "Komentar ditambahkan pada tiket <strong>{$noTicket}</strong>.",
                                            $attr === 'status_id'      => "Status tiket <strong>{$noTicket}</strong> diubah dari <span class='text-danger'>{$oldVal}</span> → <span class='text-success'>{$newVal}</span>",
                                            $attr === 'attachments'    => "Lampiran pada tiket <strong>{$noTicket}</strong> diubah: <span class='text-danger'>{$oldVal}</span> → <span class='text-success'>{$newVal}</span>",
                                            in_array($attr, ['level1','level2','level3','level4','level5'])
                                                                       => "Tiket <strong>{$noTicket}</strong> didisposisikan.",
                                            default                    => "Field <code>{$attr}</code> pada tiket <strong>{$noTicket}</strong> diubah: <span class='text-danger'>{$oldVal}</span> → <span class='text-success'>{$newVal}</span>",
                                        };
                                    @endphp

                                    <div class="timeline-item mb-6">
                                        <div class="timeline-line w-40px"></div>

                                        {{-- Icon --}}
                                        @php
                                            $iconBg  = $badgeClass === 'badge-dark' ? 'bg-dark'    : str_replace('badge-light-', 'bg-light-', $badgeClass);
                                            $iconClr = $badgeClass === 'badge-dark' ? 'text-white' : str_replace(['badge-light-', 'badge-'], ['text-', 'text-'], $badgeClass);
                                        @endphp
                                        <div class="timeline-icon symbol symbol-circle symbol-40px">
                                            <div class="symbol-label {{ $iconBg }}">
                                                <i class="bi {{ $icon }} fs-5 {{ $iconClr }}"></i>
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="timeline-content ms-5 mb-0">
                                            <div class="d-flex align-items-center mb-1 gap-3">
                                                <span class="badge {{ $badgeClass }} fw-bold fs-8 px-3">
                                                    {{ $label }}
                                                </span>
                                                <span class="text-muted fw-semibold fs-8">
                                                    <i class="bi bi-clock me-1"></i>{{ $time }}
                                                </span>
                                                <span class="text-dark fw-bold fs-8">
                                                    <i class="bi bi-person me-1"></i>{{ $userName }}
                                                    @if($userRole)
                                                        <span class="text-muted fw-normal">({{ $userRole }})</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="text-gray-600 fs-7">{!! $desc !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                @if ($paginator && $paginator->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                        <span class="text-muted fs-7">
                            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} entri
                        </span>
                        {{ $paginator->links('pagination::bootstrap-5') }}
                    </div>
                @elseif ($paginator)
                    <div class="text-center text-muted fs-7 mt-3">
                        Total {{ $paginator->total() }} entri
                    </div>
                @endif
            @endif

        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e4e6ef;
        }
        .timeline-item {
            position: relative;
            display: flex;
            align-items: flex-start;
        }
        .timeline-icon {
            position: absolute;
            left: -2rem;
            flex-shrink: 0;
        }
        .timeline-content {
            flex: 1;
            padding: 0.5rem 1rem;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 3px solid #e4e6ef;
        }
        .timeline-item:last-child {
            margin-bottom: 0 !important;
        }
    </style>
@endsection
