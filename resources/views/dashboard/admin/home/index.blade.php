@extends('layouts.dashboard.app')

@section('title')
    Dashboard | PLN Icon+
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

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card mt-2">
                <div class="card-body">
                    <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3 mt-3">Data Tiket</h1>
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
                                                <h4 class="card-title">{{ $tiket_proses }}</h4>
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
                </div>
            </div>
            <div class="row">
                <!-- Left Column -->
                <div class="col-xl-12 col-lg-12 mb-4">
                    <!-- First Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="text-dark fw-bolder my-1 fs-3 mt-3">Tiket</h1>
                                <select id="chartFilter" class="form-select w-auto">
                                    <option value="yearly">Pertahun</option>
                                    <option value="monthly">Perbulan</option>
                                    <option value="weekly">Perminggu</option>
                                </select>
                            </div>
                            <canvas id="ticketChart" width="80%" height="20px"></canvas>
                        </div>
                    </div>
                    <!-- Second Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tiket Prioritas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Nomor Tiket</th>
                                            <th>Kategori</th>
                                            <th>Pemilik</th>
                                            <th>Tetapkan Ke</th>
                                            <th>Prioritas</th>
                                            <th>Dibuat Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($ticketPriotitas->count())
                                            @foreach ($ticketPriotitas as $ticket)
                                                <tr class="text-center">
                                                    <td>{{ $ticket->no_ticket }}</td>
                                                    <td>{{ $ticket->category->category_name }}</td>
                                                    <td>{{ $ticket->user_s->name }}</td>
                                                    <td>{{ $ticket->assignTo->name ?? '-' }}</td>
                                                    <td>
                                                        @if ($ticket->priority_id == '4')
                                                            <span class="badge"
                                                                style="background-color:red; color: white; font-weight:bold">Critical</span>
                                                        @elseif($ticket->priority_id == '3')
                                                            <span class="badge"
                                                                style="background-color:blue; color: white; font-weight:bold">Medium</span>
                                                        @elseif($ticket->priority_id == '2')
                                                            <span class="badge"
                                                                style="background-color:#FF7F3E; color: white; font-weight:bold">High</span>
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ticketChart').getContext('2d');
            const chartFilter = document.getElementById('chartFilter');

            function fetchChartData(filter) {
                fetch(`{{ url('/admin/tickets/chart') }}?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        ticketChart.data.labels = data.labels;
                        ticketChart.data.datasets[0].data = data.tickets;
                        ticketChart.data.datasets[1].data = data.ticketsClosed;
                        ticketChart.update();
                    });
            }

            const ticketChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                            label: 'Tiket Masuk',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            data: []
                        },
                        {
                            label: 'Tiket Selesai',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1,
                            data: []
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

            chartFilter.addEventListener('change', function() {
                fetchChartData(chartFilter.value);
            });

            // Load initial chart data
            fetchChartData('yearly');
        });
    </script>
@endsection
