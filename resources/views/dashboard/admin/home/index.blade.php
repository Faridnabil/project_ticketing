@extends('layouts.dashboard.app')

@section('title')
    Dashboard | SIAK Dukcapil
@endsection

@section('content')

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
                                        <span class="text-primary fw-bold fs-3">{{ $tiket_buka }}</span>
                                        <a href="#" class="text-primary fw-bold fs-6">Diterima</a>
                                    </div>

                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col bg-light-warning px-6 py-8 rounded-2 mb-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Add-user.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-4">
                                            <i class="fas fa-spinner fa-spin text-warning" style="font-size: 24px;"></i>
                                        </span>
                                        <span class="text-warning fw-bold fs-3">{{ $tiket_proses }}</span>
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
                            <div class="card-header" style="margin-top: 30px">
                                <ul class="nav custom-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="btn-custom active font-regular" data-bs-toggle="tab" href="#pertahun"
                                            role="tab" aria-selected="false">
                                            <Strong>Data Pertahun</Strong>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn-custom font-regular mt-4" data-bs-toggle="tab" href="#prioritas"
                                            role="tab" aria-selected="true">
                                            <strong>TiketPrioritas</strong>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div id="kt_content_container" class="container mt-5">
                                <div class="card">

                                    <div class="card-body">
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <!-- Tiket Pertahun -->
                                            <div class="tab-pane fade show active" id="pertahun" role="tabpanel">
                                                <canvas id="ticketChart"></canvas>
                                            </div>
                                            <!-- Detail Keluhan -->
                                            <div class="tab-pane fade" id="prioritas" role="tabpanel">
                                                <table id="kt_datatable_example_5"
                                                    class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr
                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-125px">Nomor Tiket</th>
                                                            <th class="min-w-125px">Kategori</th>
                                                            <th class="min-w-125px">Pemilik</th>
                                                            <th class="min-w-125px">Tetapkan Ke</th>
                                                            <th class="min-w-125px">Prioritas</th>
                                                            <th class="min-w-125px">Dibuat Tanggal</th>
                                                            <th class="min-w-125px">Status</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="text-gray-600 fw-bold">
                                                        @if ($ticketPriotitas->count())
                                                            @foreach ($ticketPriotitas as $ticket)
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <!--begin::Nomor Ticket=-->
                                                                    <td>
                                                                        {{ $ticket->no_ticket }}
                                                                    </td>
                                                                    <!--end::Nomor Ticket=-->
                                                                    <!--begin::Title=-->
                                                                    <td>
                                                                        {{ $ticket->category->category_name }}
                                                                    </td>
                                                                    <!--end::Title=-->
                                                                    <!--begin::Customer Name=-->
                                                                    <td>
                                                                        {{ $ticket->customers->name }}
                                                                    </td>
                                                                    <!--end::Customer Name=-->
                                                                    <!--begin::Assign To=-->
                                                                    <td>
                                                                        @if ($ticket->assignTo != null)
                                                                            {{ $ticket->assignTo->name }}
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <!--end::Assign To=-->
                                                                    <!--begin::Priority=-->
                                                                    <td>
                                                                        @if ($ticket->priority_id == '4')
                                                                            <span class="badge"
                                                                                style="background-color:red ; color: white; font-weight:bold">
                                                                                Critical</span>
                                                                        @elseif($ticket->priority_id == '3')
                                                                            <span class="badge"
                                                                                style="background-color:blue ; color: white; font-weight:bold">
                                                                                Medium</span>
                                                                        @elseif($ticket->priority_id == '2')
                                                                            <span class="badge"
                                                                                style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                                                Hight</span>
                                                                        @elseif($ticket->priority_id == '1')
                                                                            <span class="badge"
                                                                                style="background-color:green ; color: white; font-weight:bold">
                                                                                Low</span>
                                                                        @else
                                                                            <span class="badge"
                                                                                style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold">
                                                                                -</span>
                                                                        @endif
                                                                    </td>
                                                                    <!--end::Priority=-->
                                                                    <!--begin::Payment method=-->
                                                                    <td>
                                                                        {{ date('d F Y', strtotime($ticket->created_at)) }}
                                                                    </td>
                                                                    <!--end::Payment method=-->
                                                                    <!--begin::Date=-->
                                                                    <td>
                                                                        @if ($ticket->status_id == '1')
                                                                            <span class="badge"
                                                                                style="background-color:red ; color: white; font-weight:bold">
                                                                                Tertunda</span>
                                                                        @elseif($ticket->status_id == '2')
                                                                            <span class="badge"
                                                                                style="background-color:blue ; color: white; font-weight:bold">
                                                                                Diterima</span>
                                                                        @elseif($ticket->status_id == '3')
                                                                            <span class="badge"
                                                                                style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                                                Proses</span>
                                                                        @elseif($ticket->status_id == '4')
                                                                            <span class="badge"
                                                                                style="background-color:green ; color: white; font-weight:bold">
                                                                                Selesai</span>
                                                                        @else
                                                                            <span class="badge"
                                                                                style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold">
                                                                                -</span>
                                                                        @endif
                                                                    </td>

                                                                </tr>
                                                                <!--end::Table row-->
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->
                    </div>
                    <!--end: List Widget 5-->
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->



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
