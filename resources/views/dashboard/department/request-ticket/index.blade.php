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
                    <table id="kt_datatable_example_5"
                        class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Nomor Tiket</th>
                                <th class="min-w-125px">Judul</th>
                                <th class="min-w-125px">Pemohon</th>
                                <th class="min-w-125px">Tanggal Pengajuan</th>
                                <th class="min-w-125px">Aksi</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
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
                                            <form action="{{ route('requestTicket.approveTicket', $requestTicket->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success" type="submit">Terima</button>
                                            </form>

                                            <form action="{{ route('requestTicket.rejectTicket', $requestTicket->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-danger" type="submit">Tolak</button>
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
@endsection
