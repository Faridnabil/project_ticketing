@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3 mb-3 mt-3">Show Tiket
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Detail Tiket</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    {{-- Riwayat Tiket --}}
    <style>
        .activity-log {
            padding: 15px;
            background-color: #f9fafc;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .log-header {
            margin-bottom: 10px;
        }

        .log-body span {
            display: block;
            margin-bottom: 5px;
        }

        .log-body hr {
            margin: 10px 0;
            border: 0;
            border-top: 1px solid #272727;
        }

        .btn-custom {
            margin-right: 10px;
            border: none;
            background-color: #f8f9fa;
            padding: 10px 50px;
            border-radius: 5px;
        }

        .btn-custom.active {
            background-color: #007bff;
            color: white;
        }

        .font-regular {
            font-size: 1rem;
        }
    </style>

    <style>
        .timeline {
            list-style: none;
            padding: 0;
            position: relative;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 20px;
            margin: 0;
        }

        .timeline-item {
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item.current-status .timeline-content {
            border: 2px solid #007bff;
        }

        .timeline-date {
            margin-left: 33px;
            font-weight: bold;
            color: #888;
        }

        .timeline-content {
            margin-left: 40px;
            background: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .timeline-title {
            margin: 0 0 5px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .timeline-text {
            margin: 0;
        }
    </style>


    <div id="kt_content_container" class="container">
        <div class="card">
            <div class="card-header" style="margin-top: 30px">
                <ul class="nav custom-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="btn-custom active font-regular mt-4" data-bs-toggle="tab" href="#keluhan" role="tab"
                            aria-selected="true">
                            <strong>Detail</strong>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-custom font-regular" data-bs-toggle="tab" href="#riwayat" role="tab"
                            aria-selected="false">
                            <Strong>Riwayat Aktivitas</Strong>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-custom font-regular" href="{{ url()->previous() }}"
                            style="background-color: #dc3545;color:white">
                            <Strong>Kembali</Strong>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Detail Keluhan -->
                    <div class="tab-pane fade show active" id="keluhan" role="tabpanel">
                        <div class="row g-xl-12">
                            <div class="col-xl-12">
                                <div class="card-body">
                                    <div>
                                        <!-- Ticket Header -->
                                        <div class="card shadow-sm p-4 mb-4">
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-4qx svg-icon-success ms-n2 me-3">
                                                </span>
                                                <div class="d-flex flex-column">
                                                    <h1 class="text-primary fw-bold mb-2">
                                                        {{ $ticket->category->category_name }} ({{ $ticket->no_ticket }})
                                                        <span class="badge ms-2" style="background-color: black">
                                                            @if ($ticket->level1) {{ $ticket->helpdesk->name }}
                                                            @elseif ($ticket->level2) {{ $ticket->koordinator->name }}
                                                            @elseif ($ticket->level3) {{ $ticket->staffSubdit->name }}
                                                            @elseif ($ticket->level4) {{ $ticket->siakDev->name }}
                                                            @elseif ($ticket->level5) {{ $ticket->pejabat->name }}
                                                            @else -
                                                            @endif
                                                        </span>
                                                    </h1>

                                                    <div class="text-muted mb-1">
                                                        <i class="fas fa-user me-2"></i>
                                                        <span class="fw-bolder text-dark">{{ $ticket->pic }},
                                                            {{ $ticket->jabatan ?? '-' }} - {{ $ticket->no_hp }}</span>
                                                    </div>

                                                    <div class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-2"></i>
                                                        <span class="fw-bolder text-dark">
                                                            Provinsi: {{ $ticket->province->province_name }} -
                                                            Kota/Kabupaten:
                                                            {{ $ticket->cityOrRegency->city_or_regency_name }}
                                                        </span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-3 my-3">
                                                        <i class="fas fa-ticket-alt text-primary"></i>
                                                        <strong>Prioritas:</strong>
                                                        @if ($ticket->priority_id == '4')
                                                            <span class="badge"
                                                                style="background-color:red; color:white; font-weight:bold;">
                                                                {{ $ticket->priority->priority_name }}
                                                            </span>
                                                        @elseif($ticket->priority_id == '3')
                                                            <span class="badge"
                                                                style="background-color:#FF7F3E; color:white; font-weight:bold;">
                                                                {{ $ticket->priority->priority_name }}
                                                            </span>
                                                        @elseif($ticket->priority_id == '2')
                                                            <span class="badge"
                                                                style="background-color:blue; color:white; font-weight:bold;">
                                                                {{ $ticket->priority->priority_name }}
                                                            </span>
                                                        @elseif($ticket->priority_id == '1')
                                                            <span class="badge"
                                                                style="background-color:green; color:white; font-weight:bold;">
                                                                {{ $ticket->priority->priority_name }}
                                                            </span>
                                                        @else
                                                            <span class="badge"
                                                                style="background-color:rgb(77, 75, 75); color:white; font-weight:bold;">
                                                                -
                                                            </span>
                                                        @endif

                                                        <strong>Status:</strong>
                                                        @if ($ticket->status_id == '1')
                                                            <span class="badge"
                                                                style="background-color:red; color:white; font-weight:bold;">
                                                                Tertunda
                                                            </span>
                                                        @elseif($ticket->status_id == '2')
                                                            <span class="badge"
                                                                style="background-color:blue; color:white; font-weight:bold;">
                                                                Diterima
                                                            </span>
                                                        @elseif($ticket->status_id == '3')
                                                            <span class="badge"
                                                                style="background-color:#FF7F3E; color:white; font-weight:bold;">
                                                                Proses
                                                            </span>
                                                        @elseif($ticket->status_id == '4')
                                                            <span class="badge"
                                                                style="background-color:green; color:white; font-weight:bold;">
                                                                Selesai
                                                            </span>
                                                        @elseif($ticket->status_id == '5')
                                                            <span class="badge"
                                                                style="background-color:rgb(185, 192, 2); color:white; font-weight:bold;">
                                                                Buka Kembali
                                                            </span>
                                                        @else
                                                            <span class="badge"
                                                                style="background-color:rgb(77, 75, 75); color:white; font-weight:bold;">
                                                                -
                                                            </span>
                                                        @endif

                                                    </div>

                                                </div>
                                            </div>

                                            @php
                                                use Carbon\Carbon;
                                                Carbon::setLocale('id');
                                            @endphp

                                            <div
                                                class="d-flex justify-content-between text-muted mt-3 p-3 bg-light rounded">
                                                <span>
                                                    <i class="fas fa-calendar-plus"></i> Dibuat:
                                                    <span class="fw-bolder text-dark">
                                                        {{ Carbon::parse($ticket->created_at)->translatedFormat('d F Y H:i') }}
                                                        oleh {{ $ticket->created_by }}
                                                    </span>
                                                </span>

                                                @if($ticket->updated_by)
                                                    <span>
                                                        <i class="fas fa-edit"></i> Diubah:
                                                        <span class="fw-bolder text-dark">
                                                            {{ Carbon::parse($ticket->updated_at)->translatedFormat('d F Y H:i') }}
                                                            oleh {{ $ticket->updated_by }}
                                                        </span>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Problem and Solution Section -->
                                        <div class="row g-5">
                                            <div class="col-md-6">
                                                <div class="card shadow-sm h-100 border-start border-primary border-4">
                                                    <div class="card-body p-6">
                                                        <div class="d-flex align-items-center mb-4">
                                                            <i class="fas fa-exclamation-circle fs-2 text-primary me-3"></i>
                                                            <h3 class="fw-bold text-dark mb-0">Permasalahan</h3>
                                                        </div>
                                                        <div class="fs-6 text-gray-800 lh-lg">
                                                            {!! $ticket->description ?? 'Tidak ada deskripsi tersedia.' !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card shadow-sm h-100 border-start border-success border-4">
                                                    <div class="card-body p-6">
                                                        <div class="d-flex align-items-center mb-4">
                                                            <i class="fas fa-check-circle fs-2 text-success me-3"></i>
                                                            <h3 class="fw-bold text-dark mb-0">Solusi</h3>
                                                        </div>
                                                        <div class="fs-6 text-gray-800 lh-lg">
                                                            {!! $ticket->completion_notes ?? '<span class="text-muted italic">Belum ada solusi.</span>' !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Collapsible Comments Section -->
                                        <div class="accordion accordion-icon-toggle mt-4" id="kt_accordion_comments">
                                            <div class="mb-5">
                                                <div class="accordion-header py-3 d-flex" data-bs-toggle="collapse" data-bs-target="#kt_accordion_comments_item_1">
                                                    <span class="accordion-icon"><i class="bi bi-chat-dots fs-3 text-primary"></i></span>
                                                    <h3 class="fs-4 fw-bold mb-0 ms-4 text-primary">Chat Komentar</h3>
                                                </div>
                                                <div id="kt_accordion_comments_item_1" class="collapse fs-6 ps-10" data-bs-parent="#kt_accordion_comments">
                                                    <div class="card shadow-sm">
                                                        <div class="card-body" id="kt_chat_messenger_body">
                                                            <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto scrollable-card" style="max-height: 400px; overflow-y:auto;">
                                                                @foreach ($comments as $comment)
                                                                    <div class="d-flex justify-content-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }} mb-10" id="comment-{{ $comment->id }}">
                                                                        <div class="d-flex flex-column align-items-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }}">
                                                                            <div class="d-flex align-items-center mb-2">
                                                                                <div class="symbol symbol-35px symbol-circle">
                                                                                    <div class="symbol-label fs-1 fw-bolder bg-light-success text-success">
                                                                                        {{ substr($comment->user->name, 0, 1) }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="{{ $comment->user_id == auth()->user()->id ? 'me-3' : 'ms-3' }}">
                                                                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{ $comment->user->name }}</a>
                                                                                    <span class="text-muted fs-7 mb-1">{{ $comment->created_at->locale('id')->diffForHumans() }}</span>
                                                                                    @if ($comment->user_id == $comment->ticket->customer)
                                                                                        <span class="badge badge-light-danger">Pemilik</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="p-5 rounded bg-light-{{ $comment->user_id == auth()->user()->id ? 'primary' : 'info' }} text-dark fw-bold mw-lg-600px text-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }}" data-kt-element="message-text">
                                                                                <div class="fw-normal fs-5 text-gray-700 m-0" id="message-display-{{ $comment->id }}">
                                                                                    {!! $comment->message !!}
                                                                                </div>
                                                                                <form action="{{ route('staffSubdit.tickets.update', $comment->id) }}" method="POST" class="comment-form" data-comment-id="{{ $comment->id }}">
                                                                                    @method('PUT')
                                                                                    @csrf
                                                                                    <textarea name="message" class="form-control" id="message-{{ $comment->id }}" style="display: none">{{ $comment->message }}</textarea>
                                                                                </form>
                                                                            </div>
                                                                            @if ($comment->updated_at && $comment->updated_at != $comment->created_at)
                                                                                <span class="badge badge-light-success">Dirubah</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                                                            <form class="row g-3 mt-2 needs-validation" method="POST" action="{{ route('staffSubdit.tickets.store') }}" enctype="multipart/form-data" novalidate>
                                                                @csrf
                                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                                <textarea name="message" class="form-control form-control-flush mb-3 @error('message') is-invalid @enderror" id="message" cols="10" rows="1"></textarea>
                                                                @error('message')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                                <div class="d-flex flex-stack">
                                                                    <button class="btn btn-primary" type="submit" data-kt-element="send" disabled>Kirim</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Attachments Card -->
                        <div class="col-xl-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mt-8">Lampiran Tiket</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap justify-content-start">
                                        @if (is_array(json_decode($ticket->attachments, true)) && count(json_decode($ticket->attachments, true)) > 0)
                                            @foreach (json_decode($ticket->attachments, true) as $index => $attachment)
                                                <div class="p-2">
                                                    <div class="card shadow-sm" style="width: 160px;">
                                                        <img src="{{ asset('storage/' . $attachment) }}"
                                                            alt="{{ basename($attachment) }}" class="rounded-top"
                                                            style="width: 100%; height: 120px; object-fit: cover; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_{{ $ticket->id }}_{{ $index }}" />
                                                        <div class="card-body text-center p-2">
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_{{ $ticket->id }}_{{ $index }}">
                                                                Lihat Tiket
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Tidak ada lampiran.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if (is_array(json_decode($ticket->attachments, true)) && count(json_decode($ticket->attachments, true)) > 0)
                                @foreach (json_decode($ticket->attachments, true) as $index => $attachment)
                                    <div class="modal fade" id="kt_modal_{{ $ticket->id }}_{{ $index }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Lampiran</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $attachment) }}"
                                                        alt="{{ basename($attachment) }}" class="img-fluid rounded shadow-sm" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>

                    <!-- Riwayat -->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        <div class="col-xl-12">
                            <div class="card card-xl-stretch mb-5 mb-xl-8 scrollable-card activity-log"
                                style="max-height: 756px; overflow-y: auto;">
                                <div class="card-body p-9">
                                    <h2 class="text-dark fw-bolder mb-8">Riwayat Aktivitas</h2>

                                    <div class="timeline-label">
                                        @php
                                            $groupedLogs = $activityLogs->groupBy(function($item) {
                                                return $item->created_at->format('Y-m-d H:i:s');
                                            });

                                            $mapLabel = function($attribute) {
                                                $labels = [
                                                    'priority_id' => 'Prioritas',
                                                    'status_id' => 'Status',
                                                    'category_id' => 'Kategori',
                                                    'description' => 'Deskripsi',
                                                    'pic' => 'PIC',
                                                    'jabatan' => 'Jabatan',
                                                    'province_id' => 'Provinsi',
                                                    'city_or_regency_id' => 'Kota/Kabupaten',
                                                    'level1' => 'Helpdesk',
                                                    'level2' => 'Koordinator',
                                                    'level3' => 'Staff Subdit',
                                                    'level4' => 'Siak Dev',
                                                    'level5' => 'Pejabat',
                                                    'attachments' => 'Lampiran',
                                                    'h_status_id' => 'Status',
                                                    'h_priority_id' => 'Prioritas',
                                                    'h_category_id' => 'Kategori',
                                                ];
                                                return $labels[$attribute] ?? str_replace('_', ' ', $attribute);
                                            };

                                            $mapValue = function($attribute, $value) use ($priorities, $statuses, $categories) {
                                                if (is_null($value) || $value === '') return 'kosong';
                                                
                                                $cleanValue = strip_tags($value);

                                                switch ($attribute) {
                                                    case 'priority_id':
                                                    case 'h_priority_id':
                                                        return $priorities->firstWhere('id', $value)?->priority_name ?? $cleanValue;
                                                    case 'status_id':
                                                    case 'h_status_id':
                                                        return $statuses->firstWhere('id', $value)?->status_name ?? $cleanValue;
                                                    case 'category_id':
                                                    case 'h_category_id':
                                                        return $categories->firstWhere('id', $value)?->category_name ?? $cleanValue;
                                                    default:
                                                        return $cleanValue;
                                                }
                                            };
                                        @endphp

                                        @foreach ($groupedLogs as $timestamp => $logsAtTime)
                                            @php
                                                $firstLog = $logsAtTime->first();
                                                $user = $firstLog->user;
                                                $actionType = $firstLog->attribute;
                                                
                                                // Determine Icon and Color
                                                $color = 'primary';
                                                
                                                if ($actionType == 'CREATE_TICKET') {
                                                    $color = 'success';
                                                } elseif ($actionType == 'DELETE_TICKET') {
                                                    $color = 'danger';
                                                } elseif ($actionType == 'ADD_COMMENT') {
                                                    $color = 'info';
                                                } elseif (in_array($actionType, ['status_id', 'h_status_id'])) {
                                                    $color = 'warning';
                                                }
                                            @endphp

                                            <!--begin::Item-->
                                            <div class="timeline-item">
                                                <!--begin::Label-->
                                                <div class="timeline-label fw-bold text-gray-800 fs-6" style="width: 125px">
                                                    {{ \Carbon\Carbon::parse($timestamp)->format('H:i') }}
                                                    <div class="text-muted fs-8">{{ \Carbon\Carbon::parse($timestamp)->translatedFormat('d M Y') }}</div>
                                                </div>
                                                <!--end::Label-->

                                                <!--begin::Badge-->
                                                <div class="timeline-badge">
                                                    <i class="fa fa-genderless text-{{ $color }} fs-1"></i>
                                                </div>
                                                <!--end::Badge-->

                                                <!--begin::Text-->
                                                <div class="fw-normal timeline-content text-muted ps-3">
                                                    <div class="mb-2">
                                                        <span class="text-dark fw-bolder">{{ $user->name ?? 'Sistem' }}</span>
                                                        @if($actionType == 'CREATE_TICKET')
                                                            membuat tiket baru.
                                                        @elseif($actionType == 'DELETE_TICKET')
                                                            menghapus tiket.
                                                        @elseif($actionType == 'ADD_COMMENT')
                                                            menambahkan komentar.
                                                        @else
                                                            memperbarui tiket:
                                                        @endif
                                                    </div>
                                                    <div class="bg-light p-4 rounded border border-secondary border-opacity-10">
                                                        @php
                                                            $isUpdate = !in_array($actionType, ['CREATE_TICKET', 'DELETE_TICKET', 'ADD_COMMENT']);
                                                            $currentAtTime = null;
                                                            if ($isUpdate) {
                                                                // Find matching history snapshot
                                                                $currentAtTime = $logs->first(function($h) use ($timestamp) {
                                                                    return $h->created_at->format('Y-m-d H:i:s') == $timestamp;
                                                                });
                                                            }
                                                            
                                                            // Helper to check if attribute changed in this group
                                                            $hasChange = function($attr) use ($logsAtTime) {
                                                                return $logsAtTime->firstWhere('attribute', $attr);
                                                            };
                                                        @endphp

                                                        @if($actionType == 'CREATE_TICKET')
                                                            <div class="fs-7">
                                                                <div class="mb-1"><strong>Nomor Tiket :</strong> {{ $ticket->no_ticket }}</div>
                                                                <div class="mb-1"><strong>Kategori :</strong> {{ $ticket->category->category_name }}</div>
                                                                <div class="mb-1"><strong>Prioritas :</strong> {{ $ticket->priority->priority_name }}</div>
                                                                <div class="mb-1"><strong>Status :</strong> {{ $ticket->status->status_name }}</div>
                                                                <div class="mb-1"><strong>Permasalahan :</strong> {!! $ticket->description !!}</div>
                                                                <div class="mb-1"><strong>Dibuat Oleh :</strong> {{ $user->name ?? 'Sistem' }}</div>
                                                            </div>
                                                        @elseif($actionType == 'ADD_COMMENT')
                                                            <div class="fs-7 text-italic">"{!! $firstLog->new_value !!}"</div>
                                                        @elseif($isUpdate)
                                                            <div class="fs-7">
                                                                {{-- Nomor Tiket --}}
                                                                <div class="mb-1">
                                                                    <strong>Nomor Tiket :</strong> 
                                                                    {{ $ticket->no_ticket }}
                                                                </div>

                                                                {{-- Kategori --}}
                                                                @php $logCat = $hasChange('category_id'); @endphp
                                                                <div class="mb-1">
                                                                    <strong>Kategori :</strong> 
                                                                    @if($logCat)
                                                                        <span class="text-danger decoration-line-through">"{{ $mapValue('category_id', $logCat->old_value) }}"</span>
                                                                        <span class="text-success ms-1">➔ "{{ $mapValue('category_id', $logCat->new_value) }}"</span>
                                                                    @else
                                                                        {{ $currentAtTime ? ($currentAtTime->category->category_name ?? '-') : $ticket->category->category_name }}
                                                                    @endif
                                                                </div>

                                                                {{-- Prioritas --}}
                                                                @php $logPrio = $hasChange('priority_id'); @endphp
                                                                <div class="mb-1">
                                                                    <strong>Prioritas :</strong> 
                                                                    @if($logPrio)
                                                                        <span class="text-danger decoration-line-through">"{{ $mapValue('priority_id', $logPrio->old_value) }}"</span>
                                                                        <span class="text-success ms-1">➔ "{{ $mapValue('priority_id', $logPrio->new_value) }}"</span>
                                                                    @else
                                                                        {{ $currentAtTime ? ($currentAtTime->priority->priority_name ?? '-') : $ticket->priority->priority_name }}
                                                                    @endif
                                                                </div>

                                                                {{-- Status --}}
                                                                @php $logStatus = $hasChange('status_id') ?: $hasChange('h_status_id'); @endphp
                                                                <div class="mb-1">
                                                                    <strong>Status :</strong> 
                                                                    @if($logStatus)
                                                                        <span class="text-danger decoration-line-through">"{{ $mapValue('status_id', $logStatus->old_value) }}"</span>
                                                                        <span class="text-success ms-1">➔ "{{ $mapValue('status_id', $logStatus->new_value) }}"</span>
                                                                    @else
                                                                        {{ $currentAtTime ? ($currentAtTime->status->status_name ?? '-') : $ticket->status->status_name }}
                                                                    @endif
                                                                </div>

                                                                {{-- Permasalahan --}}
                                                                @php $logDesc = $hasChange('description'); @endphp
                                                                <div class="mb-1">
                                                                    <strong>Permasalahan :</strong> 
                                                                    @if($logDesc)
                                                                        <div class="text-danger decoration-line-through fs-8">{!! $logDesc->old_value !!}</div>
                                                                        <div class="text-success fs-7">➔ {!! $logDesc->new_value !!}</div>
                                                                    @else
                                                                        <div class="fs-7 text-dark">{!! $currentAtTime ? ($currentAtTime->h_description ?? '-') : $ticket->description !!}</div>
                                                                    @endif
                                                                </div>

                                                                {{-- Solusi --}}
                                                                @php $logSol = $hasChange('completion_notes'); @endphp
                                                                <div class="mb-1">
                                                                    <strong>Solusi :</strong> 
                                                                    @if($logSol)
                                                                        <div class="text-danger decoration-line-through fs-8">{!! $logSol->old_value !!}</div>
                                                                        <div class="text-success fs-7">➔ {!! $logSol->new_value !!}</div>
                                                                    @else
                                                                        <div class="fs-7 text-dark">{!! $currentAtTime ? ($currentAtTime->h_completion_notes ?? '-') : $ticket->completion_notes !!}</div>
                                                                    @endif
                                                                </div>

                                                                {{-- Lampiran --}}
                                                                @php $logAttach = $hasChange('attachments'); @endphp
                                                                <div class="mb-1">
                                                                    <strong>Lampiran :</strong>
                                                                    @php 
                                                                        $attachments = [];
                                                                        if($logAttach) {
                                                                            $attachments = json_decode($logAttach->new_value, true) ?? [];
                                                                        } elseif($currentAtTime) {
                                                                            $attachments = json_decode($currentAtTime->h_attachments, true) ?? [];
                                                                        }
                                                                    @endphp
                                                                    
                                                                    @if(count($attachments) > 0)
                                                                        <div class="row row-cols-auto g-2 mt-1">
                                                                            @foreach ($attachments as $index => $attachment)
                                                                                <div class="col">
                                                                                    <img src="{{ asset('storage/' . $attachment) }}"
                                                                                        class="rounded shadow-sm img-thumbnail"
                                                                                        style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#activity_modal_{{ md5($timestamp) }}_{{ $index }}" />
                                                                                </div>
                                                                                
                                                                                <div class="modal fade" id="activity_modal_{{ md5($timestamp) }}_{{ $index }}" tabindex="-1" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h6 class="modal-title">Lampiran</h6>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body text-center">
                                                                                                <img src="{{ asset('storage/' . $attachment) }}" class="img-fluid rounded" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <span class="text-muted">Tidak ada lampiran.</span>
                                                                    @endif
                                                                </div>

                                                                {{-- Diubah Oleh --}}
                                                                <div class="mt-2 pt-2 border-top">
                                                                    <div class="mb-1"><strong>Diubah Oleh :</strong> {{ $user->name ?? 'Sistem' }}</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Item-->
                                        @endforeach
                                    </div>

                                    @if($activityLogs->isEmpty())
                                        <div class="text-center py-10">
                                            <i class="ki-outline ki-information-2 fs-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada riwayat aktivitas.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Refresh Komentar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const newCommentId = {{ session('new_comment_id') }};
            if (newCommentId) {
                const newCommentElement = document.getElementById('comment-' + newCommentId);
                if (newCommentElement) {
                    newCommentElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.modal').on('click', function (e) {
                if ($(e.target).hasClass('modal')) {
                    $(this).modal('hide');
                }
            });
        });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#message'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#messageEdit'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-button');
            let currentEditor;

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    const textarea = document.getElementById(`message-${commentId}`);
                    const displayParagraph = document.getElementById(
                        `message-display-${commentId}`);
                    const updateButton = document.getElementById(`update-button-${commentId}`);

                    // Hide all other textareas and update buttons
                    document.querySelectorAll('textarea').forEach(el => el.style.display = 'none');
                    document.querySelectorAll('.update-button').forEach(el => el.style.display =
                        'none');
                    // Destroy existing CKEditor instance
                    if (currentEditor) {
                        currentEditor.destroy();
                    }

                    // Show the current textarea and update button
                    textarea.style.display = 'block';
                    updateButton.style.display = 'block';

                    // Initialize CKEditor
                    ClassicEditor.create(textarea)
                        .then(editor => {
                            currentEditor = editor;
                        })
                        .catch(error => {
                            console.error(error);
                        });

                    // Hide all other display paragraphs
                    document.querySelectorAll('p[id^="message-display-"]').forEach(el => el.style
                        .display = 'block');
                    // Hide the current display paragraph
                    if (displayParagraph) {
                        displayParagraph.style.display = 'none';
                    }
                });
            });

            // Scroll to the last edited comment after page reload
            const lastEditedComment = localStorage.getItem('lastEditedComment');
            if (lastEditedComment) {
                const element = document.getElementById(`comment-${lastEditedComment}`);
                if (element) {
                    element.scrollIntoView();
                }
                localStorage.removeItem('lastEditedComment');
            }

            // Save the last edited comment ID before form submission
            const commentForms = document.querySelectorAll('.comment-form');
            commentForms.forEach(form => {
                form.addEventListener('submit', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    localStorage.setItem('lastEditedComment', commentId);
                });
            });
        });
    </script>
@endsection
