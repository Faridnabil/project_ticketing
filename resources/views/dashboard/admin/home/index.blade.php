@extends('layouts.dashboard.app')

@section('title')
    Dashboard | SIAK Dukcapil
@endsection

@section('content')
    <style>
        .col {
            flex: 1;
            margin-right: 10px;
            height: 100px;
            /* Set a specific height for uniformity */
        }

        .col:last-child {
            margin-right: 0;
        }
    </style>

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
    {{--  card title  --}}
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
    {{--  card main  --}}
    <div class="post  " id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="row">
                <!--begin::Col-->
                <div class="col-xxl-12 ">
                    <!--begin::Mixed Widget 2-->
                    <div class="card card-xxl-stretch" style="height: 190px">
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
                                    <div class="col"
                                        style="width: 25%; background-color: #e9ecef; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.75rem;">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-4">
                                            <i class="fas fa-ticket-alt text-primary" style="font-size: 24px;"></i>
                                        </span>
                                        <span class="text-primary fw-bold fs-3">{{ $total_tiket }}</span>
                                        <a href="#" class="text-primary fw-bold fs-6">Total Tiket</a>
                                    </div>

                                    <div class="col"
                                        style="width: 25%; background-color: #fff3cd; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.75rem;">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-4">
                                            <i class="fas fa-spinner fa-spin text-warning" style="font-size: 24px;"></i>
                                        </span>
                                        <span class="text-warning fw-bold fs-3">{{ $tiket_buka_proses }}</span>
                                        <a href="#" class="text-warning fw-bold fs-6">Proses</a>
                                    </div>

                                    <div class="col"
                                        style="width: 25%; background-color: #f8d7da; padding: 1rem; border-radius: 0.5rem; ">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-4">
                                            <i class="fas fa-hourglass-half fa-pulse text-danger"
                                                style="font-size: 24px;"></i>
                                        </span>
                                        <span class="text-danger fw-bold fs-3">{{ $tiket_tertunda }}</span>
                                        <a href="#" class="text-danger fw-bold fs-6 mt-2">Tiket Tertunda</a>
                                    </div>

                                    <div class="col"
                                        style="width: 25%; background-color: #d4edda; padding: 1rem; border-radius: 0.5rem;">
                                        <div class="mb-5">
                                            <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                                <span class="svg-icon svg-icon-3x svg-icon-success d-block my-4"
                                                    style="margin-top: 9px;">
                                                    <i class="fas fa-ticket-alt text-success" style="font-size: 24px;"></i>
                                                </span>
                                            </span>
                                            <span class="text-success fw-bold fs-3">{{ $tiket_selesai }}</span>
                                            <a href="#" class="text-success fw-bold fs-6 mt-2">Tiket Selesai</a>
                                        </div>
                                    </div>
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
                <div class="col-xxl-12 mt-5">
                    <!--begin::List Widget 5-->
                    <div class="card card-xxl-stretch" style="height: 380px">
                        <!--begin::Header-->
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bolder mb-2 text-dark">Monitoring Tiket
                                    @if ($selectedTicketNumber)
                                        ({{ $selectedTicketNumber }})
                                    @endif
                                </span>
                            </h3>
                            <form action="{{ route('admin.dashboard.index') }}" method="GET">
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
                                    <a href="{{ route('admin.dashboard.index') }}"
                                        class="btn btn-secondary mt-3 ms-2">Refresh</a>
                                </div>
                            </form>

                            <div class="col-xl-12 mt-6" style="max-height: 268px; overflow-y: auto;">
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
                                                alt="No History" class="img-fluid" style="width: 280px"
                                                height="150px" />
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

                <!-- Left Column -->
                <div class="col-xl-12 col-lg-12 mb-4 mt-5">
                    <!-- First Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3 mt-3">Tiket Pertahun</h1>
                            <canvas id="ticketChart" width="80%" height="20px"></canvas>
                        </div>
                    </div>
                    <!-- Second Card -->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table id="kt_datatable_example_5"
                                class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-70px">Nomor Tiket</th>
                                        <th class="min-w-70px">Kategori</th>
                                        <th class="min-w-70px">Pemilik</th>
                                        <th class="min-w-70px">Tetapkan Ke</th>
                                        <th class="min-w-70px">Prioritas</th>
                                        <th class="min-w-70px">Dibuat Tanggal</th>
                                        <th class="min-w-70px">Status</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-bold">
                                    @if ($ticketPriotitas->count())
                                        @foreach ($ticketPriotitas as $ticket)
                                            <tr>
                                                <td>{{ $ticket->no_ticket }}</td>
                                                <td>{{ $ticket->category->category_name }}</td>
                                                <td>{{ $ticket->customers->name }}</td>
                                                <td>{{ $ticket->assignTo->name ?? '-' }}</td>
                                                <td>
                                                    @if ($ticket->priority_id == '4')
                                                        <span class="badge"
                                                            style="background-color:red; color: white; font-weight:bold">Critical</span>
                                                    @elseif($ticket->priority_id == '3')
                                                        <span class="badge"
                                                            style="background-color:#FF7F3E; color: white; font-weight:bold">High</span>
                                                    @elseif($ticket->priority_id == '2')
                                                        <span class="badge"
                                                            style="background-color:blue; color: white; font-weight:bold">Medium</span>
                                                    @elseif($ticket->priority_id == '1')
                                                        <span class="badge"
                                                            style="background-color:green; color: white; font-weight:bold">Low</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('d F Y', strtotime($ticket->created_at)) }}</td>
                                                <td>
                                                    @if ($ticket->status_id == '1')
                                                        <span class="badge"
                                                            style="background-color:red; color: white; font-weight:bold">Tertunda</span>
                                                    @elseif($ticket->status_id == '2')
                                                        <span class="badge"
                                                            style="background-color:blue; color: white; font-weight:bold">Diterima</span>
                                                    @elseif($ticket->status_id == '3')
                                                        <span class="badge"
                                                            style="background-color:#FF7F3E; color: white; font-weight:bold">Proses</span>
                                                    @elseif($ticket->status_id == '4')
                                                        <span class="badge"
                                                            style="background-color:green; color: white; font-weight:bold">Selesai</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>

                <!-- Right Column -->
                {{-- <div class="col-xl-3 col-lg-12">
                    <div class="card">
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ticketChart').getContext('2d');

            fetch('{{ url('/admin/tickets/chart') }}')
                .then(response => response.json())
                .then(data => {
                    const ticketChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.months,
                            datasets: [{
                                    label: 'Tiket Masuk',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    data: data.tickets
                                },
                                {
                                    label: 'Tiket Selesai',
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1,
                                    data: data.ticketsClosed
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endsection
