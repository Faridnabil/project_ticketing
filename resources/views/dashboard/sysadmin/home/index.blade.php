@extends('layouts.dashboard.app')

@section('title')
    Dashboard | PLN Icon+
@endsection

@section('content')

    {{-- Riwayat Tiket  --}}
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

    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Dashboard
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1"></small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Tiket</p>
                                        <h4 class="card-title">{{ $total_tiket }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-spinner"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Tiket Proses</p>
                                        <h4 class="card-title">{{ $tiket_buka_proses }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Tiket Tertunda</p>
                                        <h4 class="card-title">{{ $tiket_tertunda }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="far fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Tiket Selesai</p>
                                        <h4 class="card-title">{{ $tiket_selesai }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--begin::Col-->
            <div class="col-xxl-12">
                <!--begin::List Widget 5-->
                <div class="card card-xxl-stretch">
                    <!--begin::Header-->
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bolder mb-2 text-dark">Monitoring Tiket
                                @if ($selectedTicketNumber)
                                    ({{ $selectedTicketNumber }})
                                @endif
                            </span>
                        </h3>
                        <form action="{{ route('sysadmin.dashboard.index') }}" method="GET">
                            <div class="input-group">
                                <!-- Dropdown untuk memilih nomor tiket -->
                                <select name="ticket_number" class="form-control mt-3">
                                    <option value="">Pilih Nomor Tiket</option>
                                    @foreach ($allTickets as $ticket)
                                        <option value="{{ $ticket->id }}"
                                            {{ $selectedTicketId == $ticket->id ? 'selected' : '' }}>
                                            {{ $ticket->no_ticket }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary mt-3">Filter</button>
                                <a href="{{ route('sysadmin.dashboard.index') }}"
                                    class="btn btn-secondary mt-3 ms-2">Refresh</a>
                            </div>
                        </form>

                        <div class="col-xl-12 mt-6" style="max-height: 900px; overflow-y: auto;">
                            <ul class="timeline mt-4">
                                @if ($selectedTicketId)
                                    @if ($logs->isEmpty())
                                        <div class="text-center mt-5">
                                            <img src="{{ asset('template/dist/assets/media/illustrations/terms-2.png') }} "
                                                style="width: 280px" height="150px" alt="No History" class="img-fluid" />
                                            <p class="mt-3">Tidak ada history untuk tiket yang dipilih.</p>
                                        </div>
                                    @else
                                        @foreach ($logs as $log)
                                            <li class="timeline-item {{ $loop->first ? 'current-status' : '' }}">
                                                <span
                                                    class="timeline-date">&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</span>
                                                <div class="timeline-content">
                                                    <h5 class="timeline-title mb-3">{{ $log->h_title }}</h5>
                                                    <p class="timeline-text">
                                                        <strong>Nomor Tiket :</strong> {{ $log->h_no_ticket }}<br>
                                                        <strong>Ditugaskan Ke :</strong>
                                                        {{ $log->assignTo->name ?? 'N/A' }}<br>
                                                        <strong>Jatuh Tempo :</strong>
                                                        {{ \Carbon\Carbon::parse($log->h_due_date)->translatedFormat('d F Y') ?? 'N/A' }}<br>
                                                        <strong>Status :</strong>
                                                        {{ $log->status->status_name ?? 'N/A' }}<br>
                                                        <strong>Lampiran :</strong>
                                                        @if ($log->h_attachments)
                                                            @foreach (json_decode($log->h_attachments) as $attachment)
                                                                @php
                                                                    $filename = basename($attachment);
                                                                    $parts = explode('_', $filename);
                                                                    $shortenedFilename = end($parts);
                                                                @endphp
                                                                <a href="#" class="attachment-link"
                                                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                                                    data-src="{{ asset($attachment) }}">{{ $shortenedFilename }}</a><br>
                                                            @endforeach
                                                        @else
                                                            N/A
                                                        @endif
                                                        <br>
                                                        <strong>Status Diubah Oleh :</strong>
                                                        {{ $log->statusChangedBy->name ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                @else
                                    <div class="text-center mt-5">
                                        <img src="{{ asset('template/dist/assets/media/illustrations/presentation.png') }}"
                                            alt="No History" class="img-fluid" style="width: 280px" height="150px" />
                                        <p class="mt-3">Silakan pilih nomor tiket untuk melihat history.</p>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                </div>
                <!--end: List Widget 5-->

                <!-- Modal Riwayat -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Lampiran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="modalImage" src="" alt="Attachment" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modal = document.getElementById('imageModal');
                        const modalImage = document.getElementById('modalImage');

                        modal.addEventListener('show.bs.modal', function(event) {
                            const link = event.relatedTarget;
                            const imageSrc = link.getAttribute('data-src');
                            modalImage.src = imageSrc;
                        });
                    });
                </script>

            </div>
            <!--end::Col-->

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
