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
            margin-right: 12px;
            border: 1px solid #e4e6ef;
            background-color: #ffffff;
            color: #7e8299;
            padding: 12px 25px;
            border-radius: 8px;
            display: inline-block;
            transition: all 0.2s ease-in-out;
            text-decoration: none !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            cursor: pointer;
            border-bottom: 3px solid #e4e6ef;
        }

        .btn-custom:hover {
            background-color: #f8f9fa;
            color: #009ef7;
            border-bottom-color: #009ef7;
            transform: translateY(-1px);
        }

        .btn-custom.active {
            background-color: #009ef7;
            color: white !important;
            border-color: #009ef7;
            border-bottom: 3px solid #006eb3;
            box-shadow: 0 4px 10px rgba(0, 158, 247, 0.3);
        }

        .btn-custom.active strong {
            color: white !important;
        }

        .font-regular {
            font-size: 0.95rem;
            font-weight: 600;
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

                    <div class="Header" style="margin-bottom: 25px; padding-left: 5px;">
                        <ul class="nav custom-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="btn-custom font-regular {{ request()->routeIs('helpdesk.dashboard.index') ? 'active' : '' }}"
                                    href="{{ route('helpdesk.dashboard.index') }}">
                                    Data Harian Ini
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn-custom font-regular {{ request()->routeIs('helpdesk.dashboard.indexAll') ? 'active' : '' }}"
                                    href="{{ route('helpdesk.dashboard.indexAll') }}">
                                    Data Keseluruhan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn-custom font-regular {{ request()->routeIs('helpdesk.dashboard.indexProblem') ? 'active' : '' }}"
                                    href="{{ route('helpdesk.dashboard.indexProblem') }}">
                                    Laporan Permasalahan Tiket
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
                                                            <div class="row g-3 p-5">
                                                                <div class="col-md-2">
                                                                    <label for="year" class="form-label fw-bold">Tahun</label>
                                                                    <select class="form-select" id="year" name="year">
                                                                        <option value="all">Semua Tahun</option>
                                                                        @foreach($years as $y)
                                                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="month" class="form-label fw-bold">Bulan</label>
                                                                    <select class="form-select" id="month" name="month">
                                                                        <option value="all">Semua Bulan</option>
                                                                        @for($i = 1; $i <= 12; $i++)
                                                                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="category_id" class="form-label fw-bold">Kategori</label>
                                                                    <select class="form-select" id="category_id" name="category_id">
                                                                        <option value="all">Semua Kategori</option>
                                                                        @foreach($categories as $cat)
                                                                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                                                                {{ $cat->category_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="province_id" class="form-label fw-bold">Provinsi</label>
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
                                                                <div class="col-md-2">
                                                                    <label for="city_id" class="form-label fw-bold">Kota/Kabupaten</label>
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
                                                                    <div class="d-flex w-100">
                                                                        <button type="submit" class="btn btn-primary flex-grow-1 me-2">Tampilkan</button>
                                                                        <button id="resetFilter" type="button" class="btn btn-danger">Segarkan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">

                                                            <div class="card-header">
                                                                 <h2 class="card-title fw-bolder text-black">10 Daerah dengan Permasalahan Terbanyak</h2>
                                                             </div>
                                                            <div class="card-body">
                                                                <canvas id="problemChart" height="300"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
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
                                                                                 <th style="font-weight: bold">Kategori</th>
                                                                                 <th style="font-weight: bold">Jumlah Tiket</th>
                                                                             </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                             @forelse($tableData as $data)
                                                                                 <tr>
                                                                                     <td>{{ $data['province'] }}</td>
                                                                                     <td>{{ $data['city'] }}</td>
                                                                                     <td>
                                                                                         <span class="badge"
                                                                                             style="background-color: {{ $data['color'] }}; color: white; font-weight:bold">
                                                                                             {{ $data['category'] }}
                                                                                         </span>
                                                                                     </td>
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
                const canvas = document.getElementById('problemChart');
                if (!canvas) {
                    console.error('Canvas element not found!');
                    return;
                }
                const ctx = canvas.getContext('2d');

                // Prepare data for Chart.js
                const labels = chartData.map(item => item.label);
                const data = chartData.map(item => item.total);
                const backgroundColors = chartData.map(item => item.color);
                const categoryNames = chartData.map(item => item.category_name);

                // Destroy previous chart if exists
                if (problemChart) {
                    problemChart.destroy();
                }

                // Create new chart
                problemChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Tiket',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: backgroundColors,
                            borderWidth: 1,
                            barThickness: 25,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw || 0;
                                        const categoryName = categoryNames[context.dataIndex];
                                        return `${categoryName}: ${value} tiket`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    },
                    plugins: [{
                        id: 'absolute-labels',
                        afterDraw: (chart) => {
                            const ctx = chart.ctx;
                            chart.data.datasets.forEach((dataset, i) => {
                                const meta = chart.getDatasetMeta(i);
                                meta.data.forEach((bar, index) => {
                                    const val = dataset.data[index];
                                    ctx.fillStyle = '#111';
                                    ctx.font = 'bold 12px Arial';
                                    ctx.textAlign = 'left';
                                    ctx.textBaseline = 'middle';
                                    ctx.fillText(val, bar.x + 8, bar.y);
                                });
                            });
                        }
                    }]
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
                $('#category_id').val('all');
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
                                        <td>
                                            <span class="badge"
                                                style="background-color: ${data.color}; color: white; font-weight:bold">
                                                ${data.code} - ${data.category}
                                            </span>
                                        </td>
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

