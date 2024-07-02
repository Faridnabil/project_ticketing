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
                        <div class="card-header border-0 bg-danger py-5">
                            <h3 class="card-title fw-bolder text-white">Data</h3>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <!--end::Menu-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <div class="card-body p-0">
                            <!--begin::Chart-->
                            <div class="mixed card-rounded-bottom bg-danger" data-kt-color="danger" style="height: 70px">
                            </div>
                            <!--begin::Stats-->
                            <div class="card-p mt-n20 position-relative">
                                <!--begin::Row-->
                                <div class="row g-0">
                                    <!--begin::Col-->
                                    <div class="col bg-light-warning px-6 py-8 rounded-2 me-7 mb-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Media/Equalizer.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                                        height="16" rx="1.5" />
                                                    <rect fill="#000000" x="8" y="9" width="3" height="11"
                                                        rx="1.5" />
                                                    <rect fill="#000000" x="18" y="11" width="3" height="9"
                                                        rx="1.5" />
                                                    <rect fill="#000000" x="3" y="13" width="3" height="7"
                                                        rx="1.5" />
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="text-warning fw-bold fs-3">{{ $total_tiket }}</span>
                                        <!--end::Svg Icon-->
                                        <a href="#" class="text-warning fw-bold fs-6">Data Tiket</a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col bg-light-primary px-6 py-8 rounded-2 mb-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Add-user.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <path
                                                    d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path
                                                    d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                            </svg>
                                        </span>
                                        <span class="text-primary fw-bold fs-3">{{ $tiket_proses }}</span>
                                        <!--end::Svg Icon-->
                                        <a href="#" class="text-primary fw-bold fs-6">Proses Tiket</a>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row g-0">
                                    <!--begin::Col-->
                                    <div class="col bg-light-danger px-6 py-8 rounded-2 me-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Design/Layers.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <path
                                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <path
                                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </svg>
                                        </span>
                                        <span class="text-danger fw-bold fs-3">{{ $tiket_tertunda }}</span>
                                        <!--end::Svg Icon-->
                                        <a href="#" class="text-danger fw-bold fs-6 mt-2">Tiket Tertunda</a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col bg-light-success px-6 py-8 rounded-2">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Urgent-mail.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <path
                                                    d="M9,10 L9,19 C9,19.5522847 8.55228475,20 8,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,10 C3,9.44771525 3.44771525,9 4,9 L8,9 C8.55228475,9 9,9.44771525 9,10 Z M21,10 L21,19 C21,19.5522847 20.5522847,20 20,20 L16,20 C15.4477153,20 15,19.5522847 15,19 L15,10 C15,9.44771525 15.4477153,9 16,9 L20,9 C20.5522847,9 21,9.44771525 21,10 Z"
                                                    fill="#000000" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(14.500000, 7.000000) rotate(-90.000000) translate(-14.500000, -7.000000)"
                                                    x="13.5" y="2" width="2" height="10" rx="1" />
                                            </svg>
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
                                <span class="fw-bolder mb-2 text-dark">Monitoring Tiket</span>
                            </h3>
                            <form action="{{ route('customer.dashboard.index') }}" method="GET">
                                <div class="input-group">
                                    <select name="ticket_number" class="form-control mt-3">
                                        <option value="">Pilih Nomor Tiket</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->id }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Filter</button>
                                </div>
                            </form>
                            <div class="card-toolbar">
                                <div class="card-toolbar scrollable-card" style="max-height: 290px; overflow-y:auto;">
                                    {{-- @foreach ($logs as $log)
                                        <div
                                            class="d-flex align-items-center @if (!$loop->last) mb-10 @endif">
                                            <i class="bi bi-file-earmark-text text-primary fs-1 me-5"></i>
                                            <div class="d-flex flex-column">
                                                <h5 class="text-gray-800 fw-bolder">
                                                    <strong>
                                                        @if ($log->attribute == 'priority_id')
                                                            Prioritas
                                                        @elseif($log->attribute == 'status_id')
                                                            Status
                                                        @elseif($log->attribute == 'customer')
                                                            Customer
                                                        @elseif($log->attribute == 'assign_to')
                                                            Ditugaskan Ke
                                                        @elseif($log->attribute == 'assign_to')
                                                            Ditugaskan Ke
                                                        @elseif($log->attribute == 'category_id')
                                                            Kategori
                                                        @elseif($log->attribute == 'title')
                                                            Judul
                                                        @elseif($log->attribute == 'due_date')
                                                            Tanggal Jatuh Tempo
                                                        @elseif($log->attribute == 'description')
                                                            Deskripsi
                                                        @else
                                                            {{ $log->attribute }}
                                                        @endif
                                                    </strong>:
                                                </h5>
                                                <div class="fw-bold">
                                                    @if ($log->old_value == null)
                                                        <span>
                                                            @if (is_numeric($log->new_value))
                                                                {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                            @else
                                                                {{ $log->new_value }}
                                                            @endif
                                                        </span><br>
                                                        <span>Alasan: {!! $log->reason !!}</span>
                                                        <div class="text-muted">Dirubah oleh:
                                                            {{ $log->user->name }} pada
                                                            {{ date('d F Y H:i', strtotime($log->created_at)) }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Dari:
                                                            @if (is_numeric($log->old_value))
                                                                {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                            @elseif(is_string($log->old_value))
                                                                {!! $log->old_value !!}
                                                            @endif
                                                        </span>

                                                        <span>Untuk:
                                                            @if (is_numeric($log->new_value))
                                                                {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                            @elseif (is_string($log->new_value))
                                                                {!! $log->new_value !!}
                                                            @endif
                                                        </span>
                                                        <span>Alasan: {!! $log->reason !!}</span>
                                                        <div class="text-muted">Dirubah oleh:
                                                            {{ $log->user->name }} pada
                                                            {{ date('d F Y H:i', strtotime($log->created_at)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach --}}
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
