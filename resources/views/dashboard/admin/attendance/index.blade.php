@extends('layouts.dashboard.app')

@section('title')
    Absensi | SIAK Dukcapil
@endsection

@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
    <style>
        /* Bagian Navtab */
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Absensi
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Absensi</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    <div id="kt_content_container" class="container mt-5">
        <div class="card">
            <div class="card-header" style="margin-top: 30px">
                <ul class="nav custom-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="btn-custom active font-regular mt-4" data-bs-toggle="tab" href="#keluhan" role="tab"
                            aria-selected="true">
                            <strong>Absensi</strong>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-custom font-regular" data-bs-toggle="tab" href="#riwayat" role="tab"
                            aria-selected="false">
                            <Strong>Data Perbulan</Strong>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Detail Keluhan -->
                    <div class="tab-pane fade show active" id="keluhan" role="tabpanel">
                        <div class="row gy-5 g-xl-12">
                            <div class="col-xl-5">
                                @php
                                    use Carbon\Carbon;
                                    use App\Models\Attendance;

                                    $today = Carbon::now()->format('Y-m-d');
                                    $check_in = Attendance::where('check_in', true)
                                        ->whereDate('date_check_in', $today)
                                        ->first();
                                @endphp

                                @if ($check_in)
                                    <form class="row g-3 needs-validation" method="POST"
                                        action="{{ route('attendance.update', $check_in->id) }}"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="validationCustom01" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ $check_in->name }}" readonly required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="check_out" value="{{$check_in->check_in}}">

                                        <div class="mb-4">
                                            <label for="validationCustom01" class="form-label">File</label>
                                            <input type="file" class="form-control" name="attachment">
                                        </div>

                                        <input type="hidden" name="date_check_out">
                                        <div class="mb-4">
                                            <div id="checkOutSection">
                                                <button type="submit" class="btn btn-secondary" id="checkOutBtn">Check
                                                    Out</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form class="row g-3 needs-validation" method="POST"
                                        action="{{ route('attendance.store') }}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="mb-4">
                                            <label for="validationCustom01" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="shiftSelect" class="form-label">Pilih Shift</label>
                                            <select class="form-select" id="shiftSelect" name="shift" required>
                                                <option value="">Opsi</option>
                                                <option value="Shift 1">Shift 1</option>
                                                <option value="Shift 2">Shift 2</option>
                                                <option value="Shift 3">Shift 3</option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="date_check_in">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div id="checkInSection">
                                            <button type="submit" class="btn btn-primary" id="checkInBtn">Check In</button>
                                        </div>
                                    </form>
                                @endif

                            </div>

                            <div class="col-xl-7 mt-13">
                                <!--begin::Messenger-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Table-->
                                        <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                    <th class="min-w-10px">Nama</th>
                                                    <th class="min-w-100px">Tanggal</th>
                                                    <th class="min-w-100px">Shift</th>
                                                    <th class="min-w-100px">Jam</th>
                                                    <th class="min-w-100px">Keterangan</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-bold">
                                                @if ($attendanceToday->count())
                                                    @foreach ($attendanceToday as $attendance_today)
                                                        <tr>
                                                            <td>{{ $attendance_today->name }}</td>
                                                            <td>
                                                                {{ \Carbon\Carbon::parse($attendance_today->date_check_in)->format('Y-m-d') }}
                                                            </td>
                                                            <td>
                                                                {{ $attendance_today->check_in }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($attendance_today->date_check_in)->format('H:i') }}
                                                            </td>
                                                            <td>
                                                                @if ($attendance_today->check_in)
                                                                    Masuk
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if ($attendance_today->check_out)
                                                            <tr>
                                                                <td>{{ $attendance_today->name }}</td>
                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($attendance_today->date_check_out)->format('Y-m-d') }}
                                                                </td>
                                                                <td>
                                                                    {{ $attendance_today->check_out }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($attendance_today->date_check_out)->format('H:i') }}
                                                                </td>
                                                                <td>

                                                                    <a href="{{ $attendance_today->attachment }}">
                                                                        Keluar
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @else

                                                @endif
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Messenger-->
                            </div>
                        </div>
                    </div>
                    <!-- Riwayat -->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <table id="kt_datatable_example_5"
                                class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-10px">No</th>
                                        <th class="min-w-10px">Nama</th>
                                        <th class="min-w-100px">Tanggal</th>
                                        <th class="min-w-100px">Shift</th>
                                        <th class="min-w-100px">Jam Masuk</th>
                                        <th class="min-w-100px">Jam Pulang</th>
                                        <th class="min-w-100px">Keterangan</th>
                                        <th class="min-w-100px">Fitur</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-bold">
                                    @if ($attendances->count())
                                        @foreach ($attendances as $attendance)
                                            <tr>
                                                <td class="min-w-10px">{{ $loop->iteration }}</td>
                                                <td>{{ $attendance->name }}</td>
                                                <td>{{ $attendance->date_check_in }}</td>
                                                <td>
                                                    @if ($attendance->check_in)
                                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->date_check_in)->format('Y-m-d') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->date_check_out)->format('Y-m-d') }}
                                                </td>

                                                <td>{{ $attendance->attachment }}</td>
                                                <td>
                                                    @can('Edit attendance')
                                                        <a href="{{ route('attendance.edit', $attendance->id) }}"
                                                            class="btn btn-primary px-6 align-self-center text-nowrap">Ubah</a>
                                                    @endcan
                                                    @can('Delete attendance')
                                                        <button type="reset"
                                                            class="btn btn-danger px-6 align-self-center text-nowrap"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_attendance_{{ $attendance->id }}">Hapus</button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Post-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('checkInBtn').addEventListener('click', function() {
            // Simulate check-in action
            document.getElementById('checkInSection').style.display = 'none';
            document.getElementById('checkOutSection').style.display = 'block';
        });

        document.getElementById('checkOutBtn').addEventListener('click', function() {
            // Simulate check-out action
            alert('Checked out successfully!');
            document.getElementById('kt_modal_attendance_2').modal('hide');
        });
    </script> --}}

    {{-- @foreach ($attendances as $attendance)
        <div class="modal fade" tabindex="-1" id="kt_modal_attendance_{{ $attendance->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Hapus Prioritas
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <h5>Apakah Anda yakin menghapus Prioritas ini?</h5>
                                <small
                                    class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                <ul class="mt-3 mb-0">
                                    <li>{{ $attendance->attendance_name }}</li>
                                </ul>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST"
                            class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </div><!--end modal-footer-->
                </div>
            </div>
        </div>
    @endforeach --}}
@endsection
