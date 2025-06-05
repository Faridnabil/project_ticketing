@extends('layouts.dashboard.app')

@section('title')
    Daftar Pengajuan | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Daftar Pengajuan
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Pengajuan Menangani Tiket</small>
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
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                    </div>
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table id="kt_datatable_example_1" class="table table-row-bordered gy-5">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">Nomor Tiket</th>
                                <th class="min-w-70px">Judul</th>
                                <th class="min-w-70px">Pemohon</th>
                                <th class="min-w-70px">Tanggal Pengajuan</th>
                                <th class="min-w-70px">Aksi</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-black-600 fw-bold">
                            @if ($requestTickets->count())
                                @foreach ($requestTickets as $requestTicket)
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Nomor Ticket=-->
                                        <td>
                                            {{ $requestTicket->no_ticket }}
                                        </td>
                                        <!--end::Nomor Ticket=-->
                                        <!--begin::Title=-->
                                        <td>
                                            {{ $requestTicket->title }}
                                        </td>
                                        <!--end::Title=-->
                                        <!--begin::User=-->
                                        <td>
                                            {{ $requestTicket->assignTo->name }}
                                        </td>
                                        <!--end::User=-->
                                        <!--begin::Date=-->
                                        <td>
                                            {{ date('d F Y', strtotime($requestTicket->created_at)) }}
                                        </td>
                                        <!--end::Date=-->
                                        <!--begin::Action=-->
                                        <td>
                                            <!-- Approval Form -->
                                            <form action="{{ route('requestTicket.approveTicket', $requestTicket->id) }}"
                                                method="POST" class="d-inline" onsubmit="return confirmApproval()">
                                                @csrf
                                                <button class="menu-link ms-3" type="submit"
                                                    style="background: none; border: none; padding: 0; cursor: pointer;">
                                                    <span class="menu-icon" style="fill: #13be2d;">
                                                        <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <path
                                                                    d="m10,23c0,.553-.447,1-1,1h-4c-2.757,0-5-2.243-5-5V5C0,2.243,2.243,0,5,0h8c2.757,0,5,2.243,5,5v2c0,.553-.447,1-1,1s-1-.447-1-1v-2c0-1.654-1.346-3-3-3H5c-1.654,0-3,1.346-3,3v14c0,1.654,1.346,3,3,3h4c.553,0,1,.447,1,1ZM14,6c0-.553-.447-1-1-1H5c-.553,0-1,.447-1,1s.447,1,1,1h8c.553,0,1-.447,1-1Zm-4,5c0-.553-.447-1-1-1h-4c-.553,0-1,.447-1,1s.447,1,1,1h4c.553,0,1-.447,1-1Zm-5,4c-.553,0-1,.447-1,1s.447,1,1,1h2c.553,0,1-.447,1-1s-.447-1-1-1h-2Zm19,2c0,3.859-3.141,7-7,7s-7-3.141-7-7,3.141-7,7-7,7,3.141,7,7Zm-2,0c0-2.757-2.243-5-5-5s-5,2.243-5,5,2.243,5,5,5,5-2.243,5-5Zm-3.192-1.241l-2.223,2.134c-.144.141-.379.144-.522.002l-1.131-1.108c-.396-.388-1.028-.382-1.414.014-.387.395-.381,1.027.014,1.414l1.132,1.109c.46.449,1.062.674,1.663.674s1.201-.225,1.653-.671l2.213-2.124c.398-.383.411-1.016.029-1.414-.383-.4-1.017-.411-1.414-.029Z" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </button>
                                            </form>
                                            <!-- Rejection Form -->
                                            <form action="{{ route('requestTicket.rejectTicket', $requestTicket->id) }}"
                                                method="POST" class="d-inline" onsubmit="return confirmRejection()">
                                                @csrf
                                                <button class="menu-link ms-3" type="submit"
                                                    style="background: none; border: none; padding: 0; cursor: pointer;">
                                                    <span class="menu-icon" style="fill: #c11717;">
                                                        <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <path
                                                                    d="m19.707,15.707l-1.293,1.293,1.293,1.293c.391.391.391,1.023,0,1.414-.195.195-.451.293-.707.293s-.512-.098-.707-.293l-1.293-1.293-1.293,1.293c-.195.195-.451.293-.707.293s-.512-.098-.707-.293c-.391-.391-.391-1.023,0-1.414l1.293-1.293-1.293-1.293c-.391-.391-.391-1.023,0-1.414s1.023-.391,1.414,0l1.293,1.293,1.293-1.293c.391-.391,1.023-.391,1.414,0s.391,1.023,0,1.414Zm4.293,1.293c0,3.859-3.141,7-7,7s-7-3.141-7-7,3.141-7,7-7,7,3.141,7,7Zm-2,0c0-2.757-2.243-5-5-5s-5,2.243-5,5,2.243,5,5,5,5-2.243,5-5Zm-12,6c0,.553-.447,1-1,1h-4c-2.757,0-5-2.243-5-5V5C0,2.243,2.243,0,5,0h4.515c1.869,0,3.627.728,4.95,2.05l2.501,2.502c.892.89,1.525,1.997,1.833,3.2.076.299.011.617-.179.861s-.481.387-.79.387h-5.116c-1.496,0-2.714-1.218-2.714-2.714V2.023c-.16-.015-.322-.023-.485-.023h-4.515c-1.654,0-3,1.346-3,3v14c0,1.654,1.346,3,3,3h4c.553,0,1,.447,1,1Zm2-16.714c0,.394.32.714.714.714h3.635c-.217-.374-.484-.722-.797-1.033l-2.501-2.502c-.318-.318-.671-.587-1.051-.805v3.626Z" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                        <!--end::Action=-->
                                    </tr>
                                    <!--end::Table row-->
                                @endforeach
                            @endif
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->


    <!-- JavaScript Functions for Confirmation -->
    <script>
        function confirmApproval() {
            return confirm('Apakah Anda yakin ingin menyetujui tiket ini?');
        }

        function confirmRejection() {
            return confirm('Apakah Anda yakin ingin menolak tiket ini?');
        }
    </script>

@endsection
