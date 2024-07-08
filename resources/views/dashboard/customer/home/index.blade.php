@extends('layouts.dashboard.app')

@section('title')
    Dashboard | SIAK Dukcapil
@endsection

@section('content')
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
                <div class="col-xxl-6">
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
                                        <span class="text-primary fw-bold fs-3">{{ $total_tiket }}</span>
                                        <a href="#" class="text-primary fw-bold fs-6">Total Tiket</a>
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
                        <br>
                    </div>
                    <!--end::Mixed Widget 2-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xxl-6">
                    <!--begin::List Widget 5-->
                    <div class="card card-xxl-stretch">
                        <!--begin::Header-->
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bolder mb-2 text-dark">Monitoring Tiket
                                    @if ($selectedTicketNumber)
                                        ({{ $selectedTicketNumber }})
                                    @endif
                                </span>
                            </h3>
                            <form action="{{ route('department.dashboard.index') }}" method="GET">
                                <div class="input-group">
                                    <!-- Dropdown untuk memilih nomor tiket -->
                                    <select name="ticket_number" class="form-control mt-3">
                                        <option value="">Pilih Nomor Tiket</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}"
                                                {{ $selectedTicketId == $ticket->id ? 'selected' : '' }}>
                                                {{ $ticket->no_ticket }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Filter</button>
                                </div>
                            </form>

                            <div class="card-toolbar">
                                <div class="card-toolbar scrollable-card" style="max-height: 290px; overflow-y:auto;">
                                    @foreach ($logs as $log)
                                        @if ($log->attribute != 'attachments')
                                            <div
                                                class="d-flex align-items-center @if (!$loop->last) mb-10 @endif">
                                                <i class="bi bi-file-earmark-text text-primary fs-1 me-5"></i>
                                                <div class="d-flex flex-column">
                                                    <h5 class="text-gray-800 fw-bolder">
                                                        <strong>
                                                            @if ($log->attribute == 'priority_id')
                                                                Data Prioritas
                                                            @elseif($log->attribute == 'status_id')
                                                                Data Status
                                                            @elseif($log->attribute == 'customer')
                                                                Data Customer
                                                            @elseif($log->attribute == 'assign_to')
                                                                Data Ditugaskan
                                                            @elseif($log->attribute == 'category_id')
                                                                Data Kategori
                                                            @elseif($log->attribute == 'title')
                                                                Data Judul
                                                            @elseif($log->attribute == 'due_date')
                                                                Data Tanggal Jatuh Tempo
                                                            @elseif($log->attribute == 'description')
                                                                Data Deskripsi
                                                            @else
                                                                {{ $log->attribute }}
                                                            @endif
                                                        </strong>:
                                                    </h5>
                                                    <div class="fw-bold">
                                                        @if ($log->old_value == null)
                                                            <span><strong>Data sebelum diubah :</strong>
                                                                @if (is_numeric($log->new_value))
                                                                    {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                                @else
                                                                    {{ $log->new_value }}
                                                                @endif
                                                            </span><br>
                                                            <span><strong>Alasan :</strong>{!! $log->reason !!}</span>
                                                            <div class="text-muted"><strong>Dirubah oleh :</strong>
                                                                {{ $log->user->name }} pada
                                                                {{ date('d F Y H:i', strtotime($log->created_at)) }}
                                                            </div>
                                                        @else
                                                            <span><strong>Data sebelum diubah :</strong>
                                                                @if (is_numeric($log->old_value))
                                                                    {{ $log->oldPrioritas->priority_name ?? ($log->oldCategory->category_name ?? ($log->oldUser->name ?? $log->oldStatus->status_name)) }}
                                                                @else
                                                                    {!! $log->old_value !!}
                                                                @endif
                                                            </span><br>
                                                            <span><strong>Menjadi :</strong>
                                                                @if (is_numeric($log->new_value))
                                                                    {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                                @else
                                                                    {!! $log->new_value !!}
                                                                @endif
                                                            </span><br>
                                                            <span><strong>Alasan :</strong>{!! $log->reason !!}</span>
                                                            <div class="text-muted"><strong>Diubah oleh :</strong>
                                                                {{ $log->user->name }} pada
                                                                {{ date('d F Y H:i', strtotime($log->created_at)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <!--end::Menu-->
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
@endsection
