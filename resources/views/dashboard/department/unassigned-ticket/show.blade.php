@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Tiket</small>
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
            <!--begin::Card-->
            <div class="card">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body py-2 me-xxl-9">
                            <!--begin::Layout-->
                            <div class="d-flex flex-column flex-xl-row">
                                <!--begin::Content-->
                                <div class="flex-lg-row-fluid">
                                    <!--begin::Tickets view-->
                                    <div class="card">
                                        <!--begin::Body-->
                                        <div class="card-body py-14 me-xl-7 me-0 px-0 px-xxl-9">
                                            <!--begin::Wrapper-->
                                            <div class="">
                                                <!--begin::Heading-->
                                                <div class="d-flex align-items-center mb-12">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotone/Files/File-done.svg-->
                                                    <span class="svg-icon svg-icon-4qx svg-icon-success ms-n2 me-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <path
                                                                    d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z M10.875,15.75 C11.1145833,15.75 11.3541667,15.6541667 11.5458333,15.4625 L15.3791667,11.6291667 C15.7625,11.2458333 15.7625,10.6708333 15.3791667,10.2875 C14.9958333,9.90416667 14.4208333,9.90416667 14.0375,10.2875 L10.875,13.45 L9.62916667,12.2041667 C9.29375,11.8208333 8.67083333,11.8208333 8.2875,12.2041667 C7.90416667,12.5875 7.90416667,13.1625 8.2875,13.5458333 L10.2041667,15.4625 C10.3958333,15.6541667 10.6354167,15.75 10.875,15.75 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                <path
                                                                    d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Content-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Title-->
                                                        <h1 class="text-gray-800 fw-bold">
                                                            {{ $ticket->title }}
                                                        </h1>
                                                        <!--end::Title-->
                                                        <!--begin::Info-->
                                                        <div class="">
                                                            <!--begin::Label-->
                                                            <span class="fw-bold text-muted me-6">
                                                                Pemilik : {{ $ticket->customers->name }}
                                                            </span>
                                                            <!--end::Label-->
                                                            <!--begin::Label-->
                                                            <span class="fw-bold text-muted">
                                                                Created:
                                                                <span class="fw-bolder text-gray-600 me-1">
                                                                    {{ date('d F Y H:i', strtotime($ticket->created_at)) }}
                                                                </span>
                                                            </span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Body-->
                                                <div class="mb-10">
                                                    <!--begin::Description-->
                                                    <div class="mb-15 fs-5 fw-normal text-gray-800">
                                                        <!--begin::Text-->
                                                        <div class="mb-5 fs-5">Hello,</div>
                                                        <!--end::Text-->
                                                        <!--begin::Text-->
                                                        <div class="mb-10">When you're done bundling, you should decide on
                                                            the order of the topics your article. In most cases, you can
                                                            decide to order thematically. For instance, if you want to
                                                            discuss various aspects or angles of the main topic of your blog
                                                            post. But you can also order your text chronologically or
                                                            didactically.</div>
                                                        <!--end::Text-->
                                                        <!--begin::Section-->
                                                        <div class="mb-10">In the above example we’re discussing, ordering
                                                            topics thematically makes the most sense.</div>
                                                        <!--end::Section-->
                                                        <!--begin::Section-->
                                                        <div class="m-0">Than you,
                                                            <br />Jerry
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Description-->
                                                    <hr><br>
                                                    <!--begin::Input group-->
                                                    <div class="mb-0">
                                                        <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6"
                                                            name="message" placeholder="Share Your Knowledge"></textarea>
                                                        <!--begin::Submit-->
                                                        <button type="submit"
                                                            class="btn btn-primary mt-n20 mb-20 position-relative float-end me-7">Send</button>
                                                        <!--end::Submit-->
                                                    </div>
                                                    <!--end::Input group-->
                                                </div>
                                                <!--end::Body-->
                                                <!--begin::Comments-->
                                                <div class="mb-5">
                                                    <!--begin::Comment-->
                                                    <div class="mb-9">
                                                        <!--begin::Card-->
                                                        <div class="card card-bordered w-100">
                                                            <!--begin::Body-->
                                                            <div class="card-body">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex flex-stack mb-8">
                                                                    <!--begin::Container-->
                                                                    <div class="d-flex align-items-center f">
                                                                        <!--begin::Author-->
                                                                        <div class="symbol symbol-50px me-5">
                                                                            <div
                                                                                class="symbol-label fs-1 fw-bolder bg-light-success text-success">
                                                                                S
                                                                            </div>
                                                                        </div>
                                                                        <!--end::Author-->
                                                                        <!--begin::Info-->
                                                                        <div
                                                                            class="d-flex flex-column fw-bold fs-5 text-gray-600 text-dark">
                                                                            <!--begin::Text-->
                                                                            <div class="d-flex align-items-center">
                                                                                <!--begin::Username-->
                                                                                <a href="pages/profile/overview.html"
                                                                                    class="text-gray-800 fw-bolder text-hover-primary fs-5 me-3">Sandra
                                                                                    Piquet</a>
                                                                                <!--end::Username-->
                                                                                <span class="m-0"></span>
                                                                            </div>
                                                                            <!--end::Text-->
                                                                            <!--begin::Date-->
                                                                            <span class="text-muted fw-bold fs-6">2 Days
                                                                                ago</span>
                                                                            <!--end::Date-->
                                                                        </div>
                                                                        <!--end::Info-->
                                                                    </div>
                                                                    <!--end::Container-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Desc-->
                                                                <p class="fw-normal fs-5 text-gray-700 m-0">I run a team of
                                                                    20 product managers, developers, QA and UX Previously we
                                                                    designed everything ourselves.</p>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Body-->
                                                        </div>
                                                        <!--end::Card-->
                                                    </div>
                                                    <!--end::Comment-->
                                                </div>
                                                <!--end::Comments-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Tickets view-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Sidebar-->
                                <div class="flex-column flex-lg-row-auto w-100 mw-xl-400px mb-10">
                                    <!--begin::More channels-->
                                    <div class="card bg-primary bg-opacity-5 mt-15">
                                        <!--begin::Body-->
                                        <div class="card-body p-12">
                                            <!--begin::Title-->
                                            <h2 class="text-dark fw-bolder mb-11">Riwayat Aktivitas</h2>
                                            <!--end::Title-->
                                            @foreach ($logs as $log)
                                                <!--begin::Item-->
                                                <div
                                                    class="d-flex align-items-center @if (!$loop->last) mb-10 @endif">
                                                    <!--begin::Icon-->
                                                    <i class="bi bi-file-earmark-text text-primary fs-1 me-5"></i>
                                                    <!--end::SymIconbol-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column">
                                                        <h5 class="text-gray-800 fw-bolder">
                                                            <strong>{{ $log->attribute }}</strong>:
                                                        </h5>
                                                        <!--begin::Section-->
                                                        <div class="fw-bold">
                                                            <!--begin::Desc-->
                                                            <span class="text-muted">
                                                                Dari: {{ $log->old_value }}
                                                            </span>
                                                            <span>
                                                                Untuk: {{ $log->new_value }}
                                                            </span>
                                                            <span>
                                                                Alasan: {{ $log->reason }}
                                                            </span>

                                                            <div class="text-muted">Dirubah oleh: {{ $log->user->name }}
                                                                pada {{ $log->created_at }}
                                                            </div>
                                                            <!--end::Desc-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::Item-->
                                            @endforeach
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::More channels-->
                                </div>
                                <!--end::Sidebar-->
                            </div>
                            <!--end::Layout-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
