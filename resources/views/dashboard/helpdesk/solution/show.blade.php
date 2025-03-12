@extends('layouts.dashboard.app')

@section('title')
    Solusi Tiket | SIAK Dukcapil
@endsection

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Solusi Tiket</small>
                </h1>
            </div>
        </div>
    </div>

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

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="row g-5 g-xl-12">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8">
                        <div class="card-header" style="margin-top: 30px">
                            <ul class="nav custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="btn-custom active font-regular mt-4" data-bs-toggle="tab" href="#keluhan"
                                        role="tab">
                                        <strong>Detail</strong>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn-custom font-regular" data-bs-toggle="tab" href="#riwayat" role="tab">
                                        <strong>Riwayat Aktivitas</strong>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn-custom font-regular" href="{{ url()->previous() }}"
                                        style="background-color: #dc3545; color: white;">
                                        <strong>Kembali</strong>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body pt-5">
                            <div class="tab-content">
                                <!-- Detail Solution -->
                                <div class="tab-pane fade show active" id="keluhan" role="tabpanel">
                                    <div class="row">
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
                                                            Provinsi : {{ $ticket->province->province_name }} -
                                                            Kota/Kabupaten :
                                                            {{ $ticket->cityOrRegency->city_or_regency_name }}
                                                        </span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-3 my-3">
                                                        <i class="fas fa-ticket-alt text-primary"></i>
                                                        <strong>Prioritas :</strong>
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

                                                        <strong>Status :</strong>
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
                                                        <strong>Kategori Permasalahan :</strong>

                                                        <span class="badge"
                                                            style="background-color:rgb(218, 33, 33); color:white; font-weight:bold;">
                                                            {{ $ticket->category->category_name }}
                                                        </span>

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
                                        <div class="card shadow-sm p-7 col-md-6 mb-4 mt-3">
                                            <h1>Permasalahan</h1>
                                            <p class="fs-5 fw-normal text-gray-800">
                                                {!! old('description', $ticket->description) !!}
                                            </p>
                                        </div>
                                        <div class="card shadow-sm p-7 col-md-6 mb-4 mt-3">
                                            <h1>Solusi</h1>
                                            <p class="fs-5 fw-normal text-gray-800">
                                                {!! old('completion_notes', $ticket->completion_notes) !!}
                                            </p>
                                        </div>
                                    </div>
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
                                                                        <button class="btn btn-sm btn-primary"
                                                                            data-bs-toggle="modal"
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
                                                                    alt="{{ basename($attachment) }}"
                                                                    class="img-fluid rounded shadow-sm" />
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
                                            <div class="card-body p-12">
                                                <h2 class="text-dark fw-bolder mb-11">Riwayat Aktivitas</h2>
                                                <ul class="timeline">
                                                    @foreach ($logs as $log)
                                                        <li class="timeline-item {{ $loop->first ? 'current-status' : '' }}">
                                                            <span class="timeline-date">
                                                                {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}
                                                            </span>
                                                            <div class="timeline-content">
                                                                <h5 class="timeline-title mb-3">{{ $log->h_title }}</h5>
                                                                <p class="timeline-text">
                                                                    <strong>Nomor Tiket :</strong> {{ $log->h_no_ticket }}<br>
                                                                    <strong>Kategori :</strong>
                                                                    {{ $log->category->category_name }}<br>
                                                                    <strong>Prioritas :</strong>
                                                                    {{ $log->priority->priority_name ?? 'N/A' }}<br>
                                                                    <strong>Status :</strong>
                                                                    {{ $log->status->status_name ?? 'N/A' }}<br>

                                                                    @if ($log->h_level1)
                                                                        <strong>Disposisi :</strong>
                                                                        {{ $log->helpdesk->name ?? 'N/A' }}<br>
                                                                    @elseif ($log->h_level2)
                                                                        <strong>Disposisi :</strong>
                                                                        {{ $log->koordinator->name ?? 'N/A' }}<br>
                                                                    @elseif ($log->h_level3)
                                                                        <strong>Disposisi :</strong>
                                                                        {{ $log->staffSubdit->name ?? 'N/A' }}<br>
                                                                    @elseif ($log->h_level4)
                                                                        <strong>Disposisi :</strong>
                                                                        {{ $log->siakDev->name ?? 'N/A' }}<br>
                                                                    @elseif ($log->h_level5)
                                                                        <strong>Disposisi :</strong>
                                                                        {{ $log->pejabat->name ?? 'N/A' }}<br>
                                                                    @endif

                                                                    <strong>Lampiran :</strong>
                                                                    @if (is_array(json_decode($log->h_attachments, true)) && count(json_decode($log->h_attachments, true)) > 0)
                                                                        <div class="row row-cols-auto g-2 mt-3">
                                                                            @foreach (json_decode($log->h_attachments, true) as $index => $attachment)
                                                                                <div class="col">
                                                                                    <img src="{{ asset('storage/' . $attachment) }}"
                                                                                        alt="{{ basename($attachment) }}"
                                                                                        class="rounded shadow-sm img-thumbnail"
                                                                                        style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#riwayat_modal_{{ $log->id }}_{{ $index }}" />
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <p class="text-muted">Tidak ada lampiran.</p>
                                                                    @endif

                                                                <br>
                                                                <strong>Status Diubah Oleh :</strong>
                                                                {{ $log->statusChangedBy->name ?? 'N/A' }}<br>
                                                                <strong>Tiket Dibuat Oleh :</strong>
                                                                {{ $log->h_created_by ?? 'N/A' }}
                                                                </p>
                                                            </div>
                                                        </li>

                                                        <!-- Modal Riwayat -->
                                                        @if (is_array(json_decode($log->h_attachments, true)) && count(json_decode($log->h_attachments, true)) > 0)
                                                            @foreach (json_decode($log->h_attachments, true) as $index => $attachment)
                                                                <div class="modal fade" id="riwayat_modal_{{ $log->id }}_{{ $index }}"
                                                                    tabindex="-1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h6 class="modal-title">Foto</h6>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                <img src="{{ asset('storage/' . $attachment) }}"
                                                                                    alt="{{ basename($attachment) }}"
                                                                                    class="img-fluid rounded" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- End tab-content -->
                        </div> <!-- End card-body -->
                    </div> <!-- End card -->
                </div> <!-- End col-xl-12 -->
            </div> <!-- End row -->
        </div> <!-- End container -->

    </div>


@endsection
