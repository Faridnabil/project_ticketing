@extends('layouts.dashboard.app')

@section('title')
    Dashboard | Ticketing
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

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xxl-4">
                    <!--begin::Mixed Widget 2-->
                    <div class="card card-xxl-stretch">
                        <!--begin::Header-->
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">Data Keseluruhan</h3>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <!--end::Menu-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <div class="card-body p-0">
                            <!--begin::Chart-->
                            <div class="mixed card-rounded-bottom bg-primary" data-kt-color="primary" style="height: 28px">
                            </div>
                            <!--begin::Stats-->
                            <div class="card-p mt-n20 position-relative">
                                <!--begin::Row-->
                                <div class="row g-0">
                                    <div class="col bg-light-primary px-6 py-8 rounded-2 me-7 mb-7">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-4">
                                            <i class="fas fa-ticket-alt text-primary" style="font-size: 24px;"></i>
                                            <!-- Icon tiket diterima -->
                                        </span>
                                        <span class="text-primary fw-bold fs-3">{{ $total_tiket }}</span>
                                        <a href="#" class="text-primary fw-bold fs-6">Total Tiket</a>
                                    </div>

                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col bg-light-warning px-6 py-8 rounded-2 mb-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Add-user.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-4">
                                            <i class="fas fa-spinner fa-spin text-warning" style="font-size: 24px;"></i>
                                        </span>
                                        <span class="text-warning fw-bold fs-3">{{ $tiket_buka_proses }}</span>
                                        <!--end::Svg Icon-->
                                        <a href="#" class="text-warning fw-bold fs-6">Proses</a>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row g-0">
                                    <!--begin::Col-->
                                    <div class="col bg-light-danger px-6 py-8 rounded-2 me-7">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-4">
                                            <i class="fas fa-hourglass-half fa-pulse text-danger"
                                                style="font-size: 24px;"></i>
                                            <!-- Icon tiket yang tertunda dengan animasi -->
                                        </span>
                                        <span class="text-danger fw-bold fs-3">{{ $tiket_tertunda }}</span>

                                        <a href="#" class="text-danger fw-bold fs-6 mt-2">Tiket Tertunda</a>
                                    </div>

                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col bg-light-success px-6 py-8 rounded-2">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Urgent-mail.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                            <span class="svg-icon svg-icon-3x svg-icon-success d-block my-4">
                                                <i class="fas fa-ticket-alt text-success" style="font-size: 24px;"></i>
                                                <!-- Icon tiket diterima -->
                                            </span>
                                        </span>
                                        <span class="text-success fw-bold fs-3">{{ $tiket_selesai }}</span>
                                        <!--end::Svg Icon-->
                                        <a href="#" class="text-success fw-bold fs-6 mt-2">Tiket Selesai</a>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <br>
                        <br>
                    </div>
                    <!--end::Mixed Widget 2-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xxl-8">
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
                            <form action="{{ route('department.dashboard.index') }}" method="GET">
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
                                    <a href="{{ route('department.dashboard.index') }}"
                                        class="btn btn-secondary mt-3 ms-2">Refresh</a>
                                </div>
                            </form>

                            <div class="col-xl-12 mt-6" style="max-height: 250px; overflow-y: auto;">
                                <ul class="timeline">
                                    @if ($selectedTicketId)
                                        @if ($logs->isEmpty())
                                            <div class="text-center mt-5">
                                                <img src="{{ asset('template/dist/assets/media/illustrations/terms-2.png') }} "
                                                    style="width: 280px" height="150px" alt="No History"
                                                    class="img-fluid" />
                                                <p class="mt-3">Tidak ada history untuk tiket yang dipilih.</p>
                                            </div>
                                        @else
                                            @foreach ($logs as $log)
                                                <li class="timeline-item {{ $loop->first ? 'current-status' : '' }}">
                                                    <span
                                                        class="timeline-date">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</span>
                                                    <div class="timeline-content">
                                                        <h5 class="timeline-title mb-3">{{ $log->h_title }}</h5>
                                                        <p class="timeline-text">
                                                            <strong>Nomor Tiket :</strong> {{ $log->h_no_ticket }}<br>
                                                            <strong>Nama Pemilik :</strong>
                                                            {{ $log->customers->name ?? 'N/A' }}<br>
                                                            <strong>Prioritas :</strong>
                                                            {{ $log->priority->priority_name ?? 'N/A' }}<br>
                                                            <strong>Jatuh Tempo :</strong>
                                                            {{ \Carbon\Carbon::parse($log->h_due_date)->translatedFormat('d F Y') ?? 'N/A' }}
                                                            <br>
                                                            <strong>Status :</strong>
                                                            {{ $log->status->status_name ?? 'N/A' }}<br>
                                                            <strong>Kategori :</strong>
                                                            {{ $log->category->category_name }}<br>
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
                                                            {{ $log->statusChangedByUser->name ?? 'N/A' }}
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
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
