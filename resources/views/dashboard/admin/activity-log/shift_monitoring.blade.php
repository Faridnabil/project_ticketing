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
            <div class="d-flex gap-2">
                <a href="{{ route('admin.activityLog.index') }}" class="btn btn-sm btn-light-primary">
                    <i class="bi bi-list-ul me-1"></i> Detail Log
                </a>
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
                                <th class="min-w-100px">Tiket Dikerjakan</th>
                                <th class="min-w-100px">Total Aksi</th>
                                <th class="min-w-100px">Status Shift</th>
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
                                        @if ($att->tiket_dikerjakan > 0)
                                            <span class="badge badge-light-success fw-bold fs-6 px-3 py-2">
                                                {{ $att->tiket_dikerjakan }} tiket
                                            </span>
                                        @else
                                            <span class="text-muted fs-7">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($att->total_aktivitas > 0)
                                            <span class="badge badge-light-primary fw-bold fs-7">
                                                {{ $att->total_aktivitas }} aksi
                                            </span>
                                        @else
                                            <span class="text-muted fs-7">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($isAktif)
                                            <span class="badge badge-light-success fw-bold fs-7 px-3">
                                                <i class="bi bi-check-circle me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-light-danger fw-bold fs-7 px-3">
                                                <i class="bi bi-dash-circle me-1"></i> Tidak Ada Aktivitas
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
