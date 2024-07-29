@extends('layouts.dashboard.app')

@section('title')
    Dashboard | PLN Icon+
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
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
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
