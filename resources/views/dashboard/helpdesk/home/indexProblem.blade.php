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

    <!--begin::Toolbar-->
    {{-- card title --}}
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
    {{-- card main --}}
    <div class="post" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="row">
                <!--begin::Col-->
                <div class="col-xxl-12 ">

                    <div class="Header" style="margin-bottom: 30px">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="btn-custom font-regular mt-4 {{ request()->routeIs('helpdesk.dashboard.index') ? 'active' : '' }}"
                                    href="{{ route('helpdesk.dashboard.index') }}">
                                    <strong>Data Harian ini</strong>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn-custom font-regular {{ request()->routeIs('helpdesk.dashboard.indexAll') ? 'active' : '' }}"
                                    href="{{ route('helpdesk.dashboard.indexAll') }}">
                                    <strong>Data Keseluruhan</strong>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn-custom font-regular {{ request()->routeIs('helpdesk.dashboard.indexProblem') ? 'active' : '' }}"
                                    href="{{ route('helpdesk.dashboard.indexProblem') }}">
                                    <strong>Laporan Permasalahan Tiket</strong>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <!-- Data Harian -->
                        <div class="tab-pane fade show active" id="harian" role="tabpanel">
                            <div id="materialize-container"></div>

                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card card-xxl-stretch">
                                          <div class="card-header border-0 bg-primary py-5">
                                                <h2 class="card-title fw-bolder text-white">Laporan Permasalahan Tiket per Daerah</h2>
                                            </div>
                                            <div class="card-body">

                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <form id="filterForm">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <label for="year">Tahun</label>
                                                                    <select class="form-select" id="year" name="year">
                                                                        <option value="all">Semua Tahun</option>
                                                                        @foreach($years as $y)
                                                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="month">Bulan</label>
                                                                    <select class="form-select" id="month" name="month">
                                                                        <option value="all">Semua Bulan</option>
                                                                        @for($i = 1; $i <= 12; $i++)
                                                                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="province_id">Provinsi</label>
                                                                    <select class="form-select" id="province_id"
                                                                        name="province_id">
                                                                        <option value="all">Semua Provinsi</option>
                                                                        @foreach($provinces as $province)
                                                                            <option value="{{ $province->id }}" {{ $provinceId == $province->id ? 'selected' : '' }}>
                                                                                {{ $province->province_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="city_id">Kota/Kabupaten</label>
                                                                    <select class="form-select" id="city_id" name="city_id"
                                                                        {{ !$provinceId || $provinceId == 'all' ? 'disabled' : '' }}>
                                                                        <option value="all">Semua Kota/Kabupaten</option>
                                                                        @if($provinceId && $provinceId != 'all')
                                                                            @foreach(\App\Models\CityOrRegency::where('province_id', $provinceId)->get() as $city)
                                                                                <option value="{{ $city->id }}" {{ $cityId == $city->id ? 'selected' : '' }}>
                                                                                    {{ $city->city_or_regency_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 d-flex align-items-end">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Filter</button>
                                                                        <button id="resetFilter" class="btn btn-danger ms-2">Segarkan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card">

                                                            <div class="card-header">
                                                                <h2 class="card-title fw-bolder text-black">10 Daerah dengan Permasalahan Terbanyak</h2>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="problemChart" height="300"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                 <h2 class="card-title fw-bolder text-black">Detail Kategori Permasalahan</h2>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-row-bordered gy-5">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-weight: bold">Provinsi</th>
                                                                                <th style="font-weight: bold">Kota/Kabupaten</th>
                                                                                <th style="font-weight: bold">Kategori Permasalahan</th>
                                                                                <th style="font-weight: bold">Deskripsi</th>
                                                                                <th style="font-weight: bold">Jumlah Tiket</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @forelse($tableData as $data)
                                                                                <tr>
                                                                                    <td>{{ $data['province'] }}</td>
                                                                                    <td>{{ $data['city'] }}</td>
                                                                                    <td>{{ $data['category'] }}</td>
                                                                                    <td>{{ $data['description'] }}</td>
                                                                                    <td>{{ $data['total'] }}</td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr>
                                                                                    <td colspan="4" class="text-center">Tidak
                                                                                        ada data</td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize chart variable
            let problemChart = null;

            // Function to initialize or update chart
            function initChart(chartData) {
                const ctx = document.getElementById('problemChart');
                if (!ctx) {
                    console.error('Canvas element not found!');
                    return;
                }

                // Prepare data for Chart.js
                const labels = chartData.map(item => item.region);
                const data = chartData.map(item => item.total);
                const backgroundColors = chartData.map(item => item.color);
                const categories = chartData.map(item => item.category);

                // Destroy previous chart if exists
                if (problemChart) {
                    problemChart.destroy();
                }

                // Create new chart
                problemChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Tiket',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 20,
                                    padding: 15,
                                    generateLabels: function(chart) {
                                        const data = chart.data;
                                        if (data.labels.length && data.datasets.length) {
                                            return data.labels.map(function(label, i) {
                                                return {
                                                    text: label + ' (' + data.datasets[0].data[i] + ')',
                                                    fillStyle: data.datasets[0].backgroundColor[i],
                                                    hidden: false,
                                                    index: i
                                                };
                                            });
                                        }
                                        return [];
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} tiket (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Initialize with server-side data
            initChart(@json($chartData));

            // Dynamic city dropdown based on province selection
            $('#province_id').change(function() {
                const provinceId = $(this).val();

                if (provinceId && provinceId !== "all") {
                    $('#city_id').prop('disabled', false);

                    $.get(`/helpdesk/tickets/cities/${provinceId}`, function(cities) {
                        $('#city_id').empty();
                        $('#city_id').append('<option value="all">Semua Kota/Kabupaten</option>');

                        cities.forEach(function(city) {
                            $('#city_id').append(`<option value="${city.id}">${city.city_or_regency_name}</option>`);
                        });
                    });
                } else {
                    $('#city_id').prop('disabled', true);
                    $('#city_id').empty();
                    $('#city_id').append('<option value="all">Semua Kota/Kabupaten</option>');
                }
            });

            // Reset filter button functionality
            $('#resetFilter').on('click', function () {
                // Reset all filter fields
                $('#year').val('all');
                $('#month').val('all');
                $('#province_id').val('all');
                $('#city_id').val('all').prop('disabled', true).html('<option value="all">Semua Kota/Kabupaten</option>');

                // Trigger form submit to reload data
                $('#filterForm').submit();
            });


            // AJAX form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const url = "{{ route('helpdesk.dashboard.indexProblem') }}";

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        // Update chart with new data
                        initChart(response.chartData);

                        // Update table
                        let tableHtml = '';
                        if (response.tableData.length > 0) {
                            response.tableData.forEach(function(data) {
                                tableHtml += `
                                    <tr>
                                        <td>${data.province}</td>
                                        <td>${data.city}</td>
                                        <td>${data.category}</td>
                                        <td>${data.description}</td>
                                        <td>${data.total}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            tableHtml = `
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                            `;
                        }
                        $('table tbody').html(tableHtml);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection

