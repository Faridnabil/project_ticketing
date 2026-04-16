@extends('layouts.dashboard.app')

@section('title')
    Monitoring Shift | SIAK Dukcapil
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Monitoring Shift
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Aktivitas Pengguna per Shift</small>
                </h1>
            </div>

        </div>
    </div>
    <!--end::Toolbar-->

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">

            {{-- Summary Cards --}}
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center gap-4 py-5">
                            <div class="bg-light-primary rounded p-3">
                                <i class="bi bi-people fs-2x text-primary"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">{{ $attendances->pluck('user_id')->unique()->count() }}</div>
                                <div class="text-muted fs-7">Pengguna Tercatat</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center gap-4 py-5">
                            <div class="bg-light-success rounded p-3">
                                <i class="bi bi-check-circle fs-2x text-success"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">
                                    {{ $attendances->where('total_aktivitas', '>', 0)->count() }}
                                </div>
                                <div class="text-muted fs-7">Shift Aktif</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center gap-4 py-5">
                            <div class="bg-light-danger rounded p-3">
                                <i class="bi bi-x-circle fs-2x text-danger"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">
                                    {{ $attendances->where('total_aktivitas', 0)->count() }}
                                </div>
                                <div class="text-muted fs-7">Shift Tidak Ada Aktivitas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center gap-4 py-5">
                            <div class="bg-light-warning rounded p-3">
                                <i class="bi bi-ticket-perforated fs-2x text-warning"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">
                                    {{ $attendances->sum('tiket_dikerjakan') }}
                                </div>
                                <div class="text-muted fs-7">Total Tiket Dikerjakan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="card mb-5">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title fw-bolder fs-5">Filter</h3>
                </div>
                <div class="card-body pt-0">
                    <form method="GET" action="{{ route('admin.activityLog.shift') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Pengguna</label>
                                <select name="user_id" class="form-select form-select-solid">
                                    <option value="">-- Semua Pengguna --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control form-control-solid"
                                    value="{{ $tanggalMulai }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control form-control-solid"
                                    value="{{ $tanggalSelesai }}">
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.activityLog.shift') }}" class="btn btn-light w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Empty State --}}
            @if ($attendances->isEmpty())
                <div class="card">
                    <div class="card-body text-center text-muted py-15">
                        <i class="bi bi-inbox fs-2x d-block mb-3"></i>
                        <div class="fw-semibold fs-6">Tidak ada data shift untuk tanggal yang dipilih.</div>
                    </div>
                </div>
            @else
            {{-- Table Card --}}
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"></div>
                </div>
                <div class="card-body pt-0">
                    <table id="kt_datatable_example_1" class="table table-row-bordered gy-5">
                        <thead>
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-30px">No</th>
                                <th class="min-w-150px">Pengguna</th>
                                <th class="min-w-100px">Tanggal</th>
                                <th class="min-w-80px">Jam Masuk</th>
                                <th class="min-w-80px">Jam Keluar</th>
                                <th class="min-w-80px">Durasi</th>
                                <th class="min-w-100px">Shift</th>
                                <th class="min-w-100px">Tiket Dikerjakan</th>
                                <th class="min-w-100px">Aksi</th>
                                <!-- <th class="min-w-100px">Status Shift</th> -->
                            </tr>
                        </thead>
                        <tbody class="text-black-600 fw-bold">
                            @foreach ($attendances as $att)
                                @php
                                    $checkIn  = \Carbon\Carbon::parse($att->date_check_in);
                                    $checkOut = $att->date_check_out
                                        ? \Carbon\Carbon::parse($att->date_check_out)
                                        : null;

                                    $durasi = $checkOut
                                        ? $checkIn->diff($checkOut)->format('%H jam %I menit')
                                        : '-';

                                    $isAktif = $att->total_aktivitas > 0;

                                    // Tentukan shift berdasarkan jam check_in
                                    $jamCheck = $checkIn->hour;
                                    if ($att->check_in === 'Shift 1') {
                                        $shiftNum = 1;
                                        $shiftColor = 'badge-light-success'; // Hijau
                                    } elseif ($att->check_in === 'Shift 2') {
                                        $shiftNum = 2;
                                        $shiftColor = 'badge-light-warning'; // Kuning
                                    } elseif ($att->check_in === 'Shift 3') {
                                        $shiftNum = 3;
                                        $shiftColor = 'badge-light-danger'; // Merah
                                    } else {
                                        $shiftNum = '-';
                                        $shiftColor = 'badge-light-secondary'; // Abu-abu
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold fs-6">
                                                {{ $att->user->name ?? '-' }}
                                            </span>
                                            <span class="text-muted fw-semibold fs-7">
                                                {{ $att->user?->getRoleNames()->first() ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold fs-7">
                                            {{ $checkIn->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-primary fw-bold fs-7">
                                            {{ $checkIn->format('H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($checkOut)
                                            <span class="badge badge-light-info fw-bold fs-7">
                                                {{ $checkOut->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="badge badge-light-warning fw-bold fs-7">
                                                Belum absen keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted fw-semibold fs-7">{{ $durasi }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $shiftColor }} fw-bold fs-7 px-3 py-2">
                                            Shift {{ $shiftNum }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($att->tiket_dikerjakan > 0)
                                            <span  class="badge badge-light-success fw-bold fs-6 px-3 py-2">
                                                {{ $att->tiket_dikerjakan }} tiket
                                            </span>
                                        @else
                                            <span class="text-muted fs-7">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="menu-link ms-3"
                                        href="{{ route('admin.activityLog.index', [
                                                'user_id' => $att->user_id,
                                                'tanggal_mulai' => $checkIn->format('Y-m-d'),
                                                'tanggal_selesai' => $checkIn->format('Y-m-d'),
                                                'drill' => 'ticket'
                                            ]) }}"
                                        target="_blank"
                                        title="Lihat">

                                            <span class="menu-icon" style="fill: #1218ca">
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                        height="512" viewBox="0 0 24 24">
                                                        <path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z"/>
                                                        <circle cx="12" cy="12" r="4"/>
                                                    </svg>
                                                </span>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
@endsection

<style>
    /* Make badge links appear clickable */
    .cursor-pointer {
        cursor: pointer;
    }

    a.badge {
        text-decoration: none;
        transition: all 0.2s ease;
    }

    a.badge:hover {
        opacity: 0.8;
        transform: translateY(-1px);
    }
</style>
