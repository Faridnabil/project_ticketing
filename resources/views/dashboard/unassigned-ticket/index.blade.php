@extends('layouts.dashboard.app')

@section('title')
    Ticket yang Belum Ditetapkan | SIAK Ducapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Ticket yang Belum Ditetapkan
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Ticket yang Belum Ditetapkan</small>
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
                    <!--begin::Card toolbar-->
                    {{-- @can('Create Ticket')
                        <div class="card-toolbar">
                            <!--begin::Add Ticket-->
                            <a href="{{ route('ticket.create') }}" class="btn btn-primary mb-4">
                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                        <rect fill="#000000" opacity="0.5"
                                            transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)"
                                            x="4" y="11" width="16" height="2" rx="1" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Tambah Tiket</a>
                            <!--end::Add Ticket-->
                        </div>
                    @endcan --}}
                    <!--end::Card toolbar-->
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
                                <th class="min-w-125px">Pemilik</th>
                                <th class="min-w-125px">Tetapkan Ke</th>
                                <th class="min-w-125px">Prioritas</th>
                                <th class="min-w-125px">Dibuat Tanggal</th>
                                <th class="min-w-125px">Status</th>
                                <th class="text-end min-w-70px">Aksi</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @if ($tickets->count())
                                @foreach ($tickets as $ticket)
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Nomor Ticket=-->
                                        <td>
                                            {{ $ticket->no_ticket }}
                                        </td>
                                        <!--end::Nomor Ticket=-->
                                        <!--begin::Title=-->
                                        <td>
                                            {{ $ticket->title }}
                                        </td>
                                        <!--end::Title=-->
                                        <!--begin::Customer Name=-->
                                        <td>
                                            {{ $ticket->customers->name }}
                                        </td>
                                        <!--end::Customer Name=-->
                                        <!--begin::Assign To=-->
                                        <td>
                                            @if ($ticket->assignTo->name != null)
                                                {{ $ticket->assignTo->name }}
                                            @else
                                                Belum ditetapkan
                                            @endif
                                        </td>
                                        <!--end::Assign To=-->
                                        <!--begin::Priority=-->
                                        <td>
                                            @if ($ticket->priority->priority_name != null)
                                                {{ $ticket->priority->priority_name }}
                                            @else
                                                Belum ditetapkan
                                            @endif
                                        </td>
                                        <!--end::Priority=-->
                                        <!--begin::Payment method=-->
                                        <td>
                                            {{ date('d F Y', strtotime($ticket->created_at)) }}
                                        </td>
                                        <!--end::Payment method=-->
                                        <!--begin::Date=-->
                                        <td>
                                            <span class="badge"
                                                style="background-color: {{ $ticket->status->color }}; color: white; font-weight:bold">
                                                {{ $ticket->status->status_name }}
                                            </span>
                                        </td>
                                        <!--end::Date=-->
                                        <!--begin::Action=-->
                                        <td>
                                            @can('Show Ticket')
                                                <a href="{{ route('ticket.show', $ticket->id) }}"
                                                    class="btn btn-success px-6 align-self-center text-nowrap mb-2">
                                                    Lihat
                                                </a>
                                            @endcan
                                            @can('Edit Ticket')
                                                <a href="{{ route('ticket.edit', $ticket->id) }}"
                                                    class="btn btn-primary px-6 align-self-center text-nowrap mb-2">
                                                    Ubah
                                                </a>
                                            @endcan
                                            @can('Delete Ticket')
                                                <button type="reset" class="btn btn-danger px-6 align-self-center text-nowrap"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_ticket_{{ $ticket->id }}">
                                                    Hapus
                                                </button>
                                            @endcan
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

    @foreach ($tickets as $ticket)
        <div class="modal fade" tabindex="-1" id="kt_modal_ticket_{{ $ticket->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Hapus Tiket
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <h5>Apakah Anda yakin menghapus Tiket ini?</h5>
                                <small class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                <ul class="mt-3 mb-0">
                                    <li>{{ $ticket->no_ticket }}</li>
                                    <li>{{ $ticket->title }}</li>
                                </ul>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </div><!--end modal-footer-->
                </div>
            </div>
        </div>
    @endforeach
@endsection
