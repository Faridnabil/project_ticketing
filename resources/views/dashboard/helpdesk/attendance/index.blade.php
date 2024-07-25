@extends('layouts.dashboard.app')

@section('title')
    Aktifitas | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Aktifitas
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Aktifitas</small>
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
                        <a class="btn-custom font-regular nav-link {{ request('active_tab', 'absen') == 'absen' ? 'active' : '' }}"
                            data-bs-toggle="tab" href="#absen" role="tab"
                            aria-selected="{{ request('active_tab', 'absen') == 'absen' ? 'true' : 'false' }}">
                            <strong>Aktifitas</strong>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-custom font-regular nav-link {{ request('active_tab', 'absen') == 'absen_bulanan' ? 'active' : '' }}"
                            data-bs-toggle="tab" href="#absen_bulanan" role="tab"
                            aria-selected="{{ request('active_tab', 'absen') == 'absen_bulanan' ? 'true' : 'false' }}">
                            <strong>Data Perbulan</strong>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Detail Absen -->
                    <div class="tab-pane fade {{ request('active_tab', 'absen') == 'absen' ? 'show active' : '' }}"
                        id="absen" role="tabpanel">
                        <div class="row gy-5 g-xl-12">
                            <div class="col-xl-12">
                                <!--begin::List Widget 1-->
                                <div class="card card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body pt-5">
                                        @php
                                            use Carbon\Carbon;
                                            use App\Models\Attendance;
                                            use Illuminate\Support\Facades\Auth;

                                            $today = Carbon::now()->format('Y-m-d');

                                            $absen = Attendance::where('user_id', Auth::user()->id)
                                                ->where(function ($query) {
                                                    $query
                                                        ->where('check_in', 'Shift 1')
                                                        ->orWhere('check_in', 'Shift 2')
                                                        ->orWhere('check_in', 'Shift 3');
                                                })
                                                ->whereDate('date_check_in', $today)
                                                ->first();
                                        @endphp

                                        @if ($absen)
                                            <form class="row g-3 needs-validation" method="POST"
                                                action="{{ route('helpdesk.attendance.update', $absen->id) }}"
                                                enctype="multipart/form-data" novalidate>
                                                @csrf
                                                @method('PUT')

                                                <div class="col-md-6">
                                                    <label for="validationCustom01" class="form-label">Nama Lengkap</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" value="{{ $absen->name }}" readonly
                                                        required>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <input type="hidden" name="check_out" value="{{ $absen->check_in }}">
                                                    <input type="hidden" name="date_check_out" id="dateCheckOut">
                                                </div>
                                                @if ($absen->check_out == null)
                                                    <div class="col-md-6">
                                                        <label for="validationCustom01" class="form-label">File</label>
                                                        <input type="file" class="form-control" name="attachment">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Aktifitas</label>
                                                        <textarea name="activity" class="form-control" id="activity"></textarea>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Status</label>
                                                        <textarea name="status_activity" class="form-control" id="status_activity"></textarea>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div id="checkOutSection">
                                                            <button type="submit" class="btn btn-secondary"
                                                                id="checkOutBtn">
                                                                Check Out
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </form>
                                            <script>
                                                document.getElementById('checkOutBtn').addEventListener('click', function() {
                                                    const now = new Date();
                                                    const formattedDate = now.getFullYear() + '-' +
                                                        String(now.getMonth() + 1).padStart(2, '0') + '-' +
                                                        String(now.getDate()).padStart(2, '0') + ' ' +
                                                        String(now.getHours()).padStart(2, '0') + ':' +
                                                        String(now.getMinutes()).padStart(2, '0') + ':' +
                                                        String(now.getSeconds()).padStart(2, '0');
                                                    document.getElementById('dateCheckOut').value = formattedDate;
                                                });
                                            </script>
                                        @else
                                            <form class="row g-3 needs-validation" method="POST"
                                                action="{{ route('helpdesk.attendance.store') }}" enctype="multipart/form-data"
                                                novalidate>
                                                @csrf
                                                <div class="col-md-6">
                                                    <label for="validationCustom01" class="form-label">Nama Lengkap</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
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

                                                <div class="col-md-2">
                                                    <label for="shiftSelect" class="form-label">Pilih Shift</label>
                                                    <select class="form-select" id="shiftSelect" name="check_in"
                                                        required>
                                                        <option selected disabled>Opsi</option>
                                                        <option value="Shift 1">Shift 1</option>
                                                        <option value="Shift 2">Shift 2</option>
                                                        <option value="Shift 3">Shift 3</option>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="date_check_in">
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                <div class="col-md-2 mt-11">
                                                    <div id="checkInSection">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="checkInBtn">Check
                                                            In</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                        <!--end form-->
                                    </div>
                                    <!--end::Body-->
                                    <!--begin::Messenger-->
                                    <div class="card">
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Table-->
                                            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr
                                                        class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-10px">Nama</th>
                                                        <th class="min-w-100px">Tanggal</th>
                                                        <th class="min-w-100px">Shift</th>
                                                        <th class="min-w-100px">Jam</th>
                                                        <th class="min-w-100px">Absen</th>
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
                                                                    {{ date('d F Y', strtotime($attendance_today->date_check_in)) }}
                                                                </td>
                                                                <td>
                                                                    @if ($attendance_today->check_in)
                                                                        {{ $attendance_today->check_in }}
                                                                    @else
                                                                        {{ $attendance_today->check_out }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ date('H:i', strtotime($attendance_today->date_check_in)) }}
                                                                </td>
                                                                <td>
                                                                    @if ($attendance_today->check_in)
                                                                        Masuk
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @if ($attendance_today->check_in)
                                                                <tr>
                                                                    <td>{{ $attendance_today->name }}</td>
                                                                    <td>
                                                                        {{ date('d F Y', strtotime($attendance_today->date_check_out)) }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $attendance_today->check_out }}
                                                                    </td>
                                                                    <td>
                                                                        {{ date('H:i', strtotime($attendance_today->date_check_out)) }}
                                                                    </td>
                                                                    <td>

                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_attendances_{{ $attendance_today->id }}">
                                                                            Keluar
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
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
                                <!--end::List Widget 1-->
                            </div>
                        </div>
                    </div>
                    <!-- Bulanan -->
                    <div class="tab-pane fade {{ request('active_tab', 'absen') == 'absen_bulanan' ? 'show active' : '' }}"
                        id="absen_bulanan" role="tabpanel">
                        <div class="card-title mb-4">
                            <!--begin::Form-->
                            <form method="GET" action="{{ route('helpdesk.attendance.index') }}" class="d-flex">
                                <select name="check_in" class="form-select me-2" data-control="select2"
                                    data-placeholder="Pilih Shift">
                                    <option></option>
                                    @foreach ($allCheckIns as $checkIn)
                                        <option value="{{ $checkIn }}"
                                            {{ request('check_in') == $checkIn ? 'selected' : '' }}>
                                            {{ $checkIn }}
                                        </option>
                                    @endforeach
                                </select>
                                &nbsp;

                                <input type="date" name="start_date" class="form-control me-2"
                                    value="{{ request('start_date') }}" placeholder="Start Date">
                                &nbsp;
                                <input type="date" name="end_date" class="form-control me-2"
                                    value="{{ request('end_date') }}" placeholder="End Date">
                                &nbsp;

                                <input type="hidden" name="active_tab" id="active_tab"
                                    value="{{ request('active_tab', 'absen') }}">

                                <button type="submit" class="btn btn-primary me-1">Filter</button>
                                <a href="#" id="clear-filters" class="btn btn-danger">Hapus</a>
                            </form>
                            <!--end::Form-->

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const activeTab = urlParams.get('active_tab') || 'absen';

                                    if (activeTab) {
                                        const targetTab = document.querySelector(`a[href="#${activeTab}"]`);
                                        const tabPane = document.querySelector(`#${activeTab}`);

                                        if (targetTab && tabPane) {
                                            // Deactivate all tabs and tab contents
                                            document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
                                            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

                                            // Activate target tab and tab content
                                            targetTab.classList.add('active');
                                            tabPane.classList.add('show', 'active');
                                        }
                                    }

                                    document.getElementById('clear-filters').addEventListener('click', function(event) {
                                        event.preventDefault();
                                        const clearUrl = new URL(window.location.href);
                                        clearUrl.searchParams.delete('check_in');
                                        clearUrl.searchParams.delete('start_date');
                                        clearUrl.searchParams.delete('end_date');
                                        clearUrl.searchParams.set('active_tab', activeTab);
                                        window.location.href = clearUrl.href;
                                    });

                                    // Update the active_tab input and URL when the tab is changed
                                    document.querySelectorAll('.nav-link').forEach(tab => {
                                        tab.addEventListener('click', function() {
                                            const newTab = this.getAttribute('href').substring(1);
                                            document.getElementById('active_tab').value = newTab;

                                            const newUrl = new URL(window.location.href);
                                            newUrl.searchParams.set('active_tab', newTab);
                                            history.pushState(null, '', newUrl.href);
                                        });
                                    });
                                });
                            </script>
                        </div>

                        <table id="kt_datatable_example_5"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-10px">Nama</th>
                                    <th class="min-w-40px">Tanggal</th>
                                    <th class="min-w-40px">Shift</th>
                                    <th class="min-w-40px">Jam Masuk</th>
                                    <th class="min-w-40px">Jam Pulang</th>
                                    <th class="min-w-40px">Keterangan</th>
                                    <th class="min-w-40px">Aktifitas</th>
                                    <th class="min-w-40px">Status Tugas</th>
                                    {{-- <th class="min-w-100px">Fitur</th> --}}
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
                                            <td>{{ date('d F Y', strtotime($attendance->date_check_in)) }}</td>
                                            <td>
                                                @if ($attendance->check_in)
                                                    {{ $attendance->check_out }}
                                                @else
                                                    {{ $attendance->check_in }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ date('H:i', strtotime($attendance->date_check_in)) }}
                                            </td>
                                            <td>
                                                {{ date('H:i', strtotime($attendance->date_check_out)) }}
                                            </td>
                                            <td>
                                                @if ($attendance->attachment == null)
                                                @else
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_attendance_{{ $attendance->id }}_{{ $loop->index }}">
                                                        <img src="{{ asset('template/dist/assets/media/illustrations/PDF.png') }}"
                                                            width="40px" height="50px" alt="file">
                                                    </a>
                                                @endif
                                            </td>
                                            <td style="text-align: left"> {!! $attendance_today->activity !!}
                                            </td>
                                            <td style="text-align: left"> {!! $attendance_today->status_activity !!}
                                            </td>
                                        </tr>
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

    <script>
        ClassicEditor
            .create(document.querySelector('#activity'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#status_activity'))
            .catch(error => {
                console.error(error);
            });
    </script>

    @foreach ($attendances as $attendance)
        <div class="modal fade" tabindex="-1" id="kt_modal_attendance_{{ $attendance->id }}_{{ $loop->index }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            File
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <center>
                            <iframe src="{{ asset($attendance->attachment) }}"
                                style="width: 100%; height: 560px;"></iframe>
                        </center>
                    </div><!--end modal-body-->
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($attendances as $attendance_today)
        <div class="modal fade" tabindex="-1" id="kt_modal_attendances_{{ $attendance_today->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            File
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <center>
                            <iframe src="{{ asset($attendance_today->attachment) }}"
                                style="width: 100%; height: 560px;"></iframe>
                        </center>
                    </div><!--end modal-body-->
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('active_tab');

            if (activeTab) {
                const targetTab = document.querySelector(`a[href="#${activeTab}"]`);
                const tabPane = document.querySelector(`#${activeTab}`);

                if (targetTab && tabPane) {
                    // Deactivate all tabs and tab contents
                    document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
                    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

                    // Activate target tab and tab content
                    targetTab.classList.add('active');
                    tabPane.classList.add('show', 'active');
                }
            }
        });
    </script>
@endsection
