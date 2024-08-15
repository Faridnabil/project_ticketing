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
    <div class="post" id="kt_post">
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
                                        style="width: 20%; background-color: #d7f8e0; padding: 1rem; border-radius: 0.5rem;">
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-1 mb-3">
                                            <!-- SVG Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" version="1.1">
                                                <path
                                                    d="m15.999,15.5c-.188,0-.379-.053-.548-.164l-4-2.628c-.281-.186-.451-.499-.451-.836v-4.872c0-.553.447-1,1-1s1,.447,1,1v4.333l3.549,2.331c.462.304.59.924.287,1.385-.192.293-.512.451-.837.451Zm-3.285,6.475c-.236.017-.474.025-.714.025-5.514,0-10-4.486-10-10S6.486,2,12,2c3.151,0,6.112,1.512,7.988,4h-2.988c-.553,0-1,.447-1,1s.447,1,1,1h4c1.103,0,2-.897,2-2V2c0-.553-.447-1-1-1s-1,.447-1,1v2.104C18.743,1.543,15.473,0,12,0,5.383,0,0,5.383,0,12s5.383,12,12,12c.288,0,.573-.011.856-.031.551-.039.966-.518.926-1.068-.039-.55-.512-.975-1.068-.926Zm10.286-10.975c-.553,0-1,.447-1,1,0,.455-.031.913-.092,1.36-.074.548.31,1.052.856,1.126.046.006.091.009.136.009.493,0,.922-.364.99-.865.072-.536.109-1.085.109-1.63,0-.553-.447-1-1-1Zm-.863,5.396c-.484-.268-1.093-.088-1.357.396-.217.396-.464.782-.735,1.148-.328.444-.233,1.07.21,1.399.18.132.388.195.594.195.307,0,.609-.141.806-.405.323-.439.62-.902.88-1.377.266-.484.088-1.092-.396-1.357Zm-4.731,4.02c-.383.246-.783.467-1.191.656-.501.233-.719.827-.486,1.328.17.365.53.579.908.579.141,0,.284-.029.42-.093.491-.229.973-.493,1.432-.789.465-.299.599-.917.3-1.382-.299-.463-.918-.597-1.382-.3Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="m15.999,15.5c-.188,0-.379-.053-.548-.164l-4-2.628c-.281-.186-.451-.499-.451-.836v-4.872c0-.553.447-1,1-1s1,.447,1,1v4.333l3.549,2.331c.462.304.59.924.287,1.385-.192.293-.512.451-.837.451Zm-3.285,6.475c-.236.017-.474.025-.714.025-5.514,0-10-4.486-10-10S6.486,2,12,2c3.151,0,6.112,1.512,7.988,4h-2.988c-.553,0-1,.447-1,1s.447,1,1,1h4c1.103,0,2-.897,2-2V2c0-.553-.447-1-1-1s-1,.447-1,1v2.104C18.743,1.543,15.473,0,12,0,5.383,0,0,5.383,0,12s5.383,12,12,12c.288,0,.573-.011.856-.031.551-.039.966-.518.926-1.068-.039-.55-.512-.975-1.068-.926Zm10.286-10.975c-.553,0-1,.447-1,1,0,.455-.031.913-.092,1.36-.074.548.31,1.052.856,1.126.046.006.091.009.136.009.493,0,.922-.364.99-.865.072-.536.109-1.085.109-1.63,0-.553-.447-1-1-1Zm-.863,5.396c-.484-.268-1.093-.088-1.357.396-.217.396-.464.782-.735,1.148-.328.444-.233,1.07.21,1.399.18.132.388.195.594.195.307,0,.609-.141.806-.405.323-.439.62-.902.88-1.377.266-.484.088-1.092-.396-1.357Zm-4.731,4.02c-.383.246-.783.467-1.191.656-.501.233-.719.827-.486,1.328.17.365.53.579.908.579.141,0,.284-.029.42-.093.491-.229.973-.493,1.432-.789.465-.299.599-.917.3-1.382-.299-.463-.918-.597-1.382-.3Z"
                                                    fill="#000000" />
                                            </svg>
                                        </span>
                                        <span class="text-success fw-bold fs-3">{{ $total }}</span>
                                        <a href="{{ route('teknisiHardware.deviceAssets.index') }}"
                                            class="text-success fw-bold fs-6">Total Data Aset Perangkat</a>
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
            </div>

            {{-- <div class="row">
                <div class="col-xxl-12">
                    <div class="card card-xxl-stretch">
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">
                                Tiket Perbulan - {{ \Carbon\Carbon::now()->format('F Y') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="dailyDataChart" width="80%" height="20px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-xxl-12">
                    <div class="card card-xxl-stretch">
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">
                                Tiket Pertahun - {{ \Carbon\Carbon::now()->format('Y') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="ticketChart" width="80%" height="20px"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    {{-- DATA TIKET BULANAN --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxDaily = document.getElementById('dailyDataChart').getContext('2d');

            fetch('{{ url('/staff-subdit/tickets/dailyChart') }}')
                .then(response => response.json())
                .then(data => {
                    const labelsDaily = data.days;
                    const dataCreated = data.ticketsCreated;
                    const dataClosed = data.ticketsClosed;

                    const dailyDataChart = new Chart(ctxDaily, {
                        type: 'line',
                        data: {
                            labels: labelsDaily,
                            datasets: [{
                                    label: 'Tiket Masuk Harian',
                                    data: dataCreated,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    fill: true
                                },
                                {
                                    label: 'Tiket Selesai Harian',
                                    data: dataClosed,
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1,
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.1
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching daily data:', error));
        });
    </script> --}}

    {{-- DATA TIKET TAHUNAN --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ticketChart').getContext('2d');

            fetch('{{ url('/staff-subdit/tickets/chart') }}')
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
    </script> --}}
@endsection
