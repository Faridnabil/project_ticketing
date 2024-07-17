@extends('layouts.dashboard.app')

@section('title')
    Ticket yang Ditetapkan | SIAK Dukcapil
@endsection

@section('content')
    {{-- Select Status Tiket --}}
    <style>
        .custom-select-wrapper {
            position: relative;
            display: inline-block;
        }

        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: transparent url('data:image/svg+xml;utf8,<svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M5 7l5 5 5-5" stroke="%23000" stroke-width="2"/></svg>') no-repeat right;
            padding-right: 1.5rem;
            border: 1px solid #ccc;
            font-size: 1rem;
            margin-left: 10px;
            width: 10px;
            cursor: pointer;
        }

        .custom-select:focus {
            width: auto;
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Ticket yang Ditetapkan
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Ticket yang Ditetapkan</small>
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
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">Nomor Tiket</th>
                                <th class="min-w-70px">Judul</th>
                                <th class="min-w-70px">Pemilik</th>
                                <th class="min-w-70px">Tetapkan Ke</th>
                                <th class="min-w-70px">Prioritas</th>
                                <th class="min-w-70px">Dibuat Tanggal</th>
                                <th class="min-w-70px">Status</th>
                                <th class="min-w-70px">Aksi</th>
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
                                            @if ($ticket->assign_to != null)
                                                {{ $ticket->assignTo->name }}
                                            @else
                                                Belum ditetapkan
                                            @endif
                                        </td>
                                        <!--end::Assign To=-->
                                        <!--begin::Priority=-->
                                        <td>
                                            @if ($ticket->priority_id == '4')
                                                <span class="badge"
                                                    style="background-color:red ; color: white; font-weight:bold">
                                                    {{ $ticket->priority->priority_name }}
                                                </span>
                                            @elseif($ticket->priority_id == '3')
                                                <span class="badge"
                                                    style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                    {{ $ticket->priority->priority_name }}
                                                </span>
                                            @elseif($ticket->priority_id == '2')
                                                <span class="badge"
                                                    style="background-color:blue ; color: white; font-weight:bold">
                                                    {{ $ticket->priority->priority_name }}
                                                </span>
                                            @elseif($ticket->priority_id == '1')
                                                <span class="badge"
                                                    style="background-color:green ; color: white; font-weight:bold">
                                                    {{ $ticket->priority->priority_name }}
                                                </span>
                                            @else
                                                <span class="badge"
                                                    style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold">
                                                    -
                                                </span>
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
                                            <div class="d-flex align-items-center">
                                                @if ($ticket->status_id == '1')
                                                    <span class="badge"
                                                        style="background-color:red; color: white; font-weight:bold">
                                                        Tertunda
                                                    </span>
                                                @elseif($ticket->status_id == '2')
                                                    <span class="badge"
                                                        style="background-color:blue; color: white; font-weight:bold">
                                                        Diterima
                                                    </span>
                                                @elseif($ticket->status_id == '3')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E; color: white; font-weight:bold">
                                                        Proses
                                                    </span>
                                                @elseif($ticket->status_id == '4')
                                                    <span class="badge"
                                                        style="background-color:green; color: white; font-weight:bold">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">
                                                        -
                                                    </span>
                                                @endif
                                                @if (($ticket->status && $ticket->status_id == '2') || $ticket->status_id == '3')
                                                    <form action="{{ route('requestTicket.statusTicket', $ticket->id) }}"
                                                        method="POST" class="ml-2">
                                                        @csrf
                                                        <div class="custom-select-wrapper">
                                                            <select name="status_id" class="custom-select"
                                                                onchange="this.form.submit()">
                                                                <option value="2"
                                                                    {{ $ticket->status_id == '2' ? 'selected' : '' }}>
                                                                    Diterima</option>
                                                                <option value="3"
                                                                    {{ $ticket->status_id == '3' ? 'selected' : '' }}>
                                                                    Proses</option>
                                                                <option value="4"
                                                                    {{ $ticket->status_id == '4' ? 'selected' : '' }}>
                                                                    Selesai</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>


                                        <!--end::Date=-->
                                        <!--begin::Action=-->

                                        @if ($ticket->approval_assign_to == 0)
                                            <td>
                                                @if ($ticket->status && $ticket->status_id == '4')
                                                    @can('Show Ticket')
                                                        <a class="menu-link ms-3"
                                                            href="{{ route('assignedTicket.show', $ticket->id) }}">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                                <span class="svg-icon svg-icon-2" style="fill: #1c0eb6">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                        height="512" viewBox="0 0 24 24" version="1.1">
                                                                        <path
                                                                            d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                                        <circle cx="12" cy="12" r="4" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </a>
                                                    @endcan
                                                @else
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('assignedTicket.show', $ticket->id) }}"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_ticket_{{ $ticket->id }}"
                                                        title="Pengajuan Tiket">
                                                        <span class="menu-icon" style="fill: #1218ca">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                    height="512" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="M23.017,8.785c-.595-.542-1.364-.816-2.168-.782-.804,.038-1.544,.387-2.086,.981l-3.216,3.534c-.551-.909-1.55-1.519-2.689-1.519H3c-1.654,0-3,1.346-3,3v7c0,1.654,1.346,3,3,3H13.448l9.788-10.985c1.093-1.227,.994-3.124-.219-4.229Zm-1.274,2.899l-9.191,10.315H3c-.551,0-1-.448-1-1v-7c0-.552,.449-1,1-1H12.858c.63,0,1.142,.513,1.142,1.143,0,.564-.421,1.051-.981,1.13l-5.161,.737,.283,1.98,5.16-.737c1.175-.168,2.13-.987,2.515-2.059l4.426-4.864c.182-.199,.43-.316,.7-.329,.274-.016,.528,.081,.728,.263,.407,.371,.44,1.009,.073,1.421ZM15,2.5c0-1.379-1.122-2.5-2.5-2.5H5.5c-1.378,0-2.5,1.121-2.5,2.5v6.5H15V2.5Zm-2,4.5H5V2.5c0-.275,.224-.5,.5-.5h7c.276,0,.5,.225,.5,.5V7ZM7,3h4v2H7V3Z" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>

                                                    @if ($ticket->status_id)
                                                        @can('Edit Ticket')
                                                            <a class="menu-link ms-3"
                                                                href="{{ route('assignedTicket.edit', $ticket->id) }}"
                                                                type="button">
                                                                <span class="menu-icon" style="fill: #bd6710">
                                                                    <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                                    <span class="svg-icon svg-icon-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                            height="24px" viewBox="0 0 24 24"
                                                                            version="1.1">
                                                                            <path
                                                                                d="M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z" />
                                                                            <path
                                                                                d="M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                            </a>
                                                        @endcan
                                                    @endif

                                                    @can('Show Ticket')
                                                        <a class="menu-link ms-3"
                                                            href="{{ route('assignedTicket.show', $ticket->id) }}">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                                <span class="svg-icon svg-icon-2" style="fill: #1c0eb6">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                        height="512" viewBox="0 0 24 24" version="1.1">
                                                                        <path
                                                                            d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                                        <circle cx="12" cy="12" r="4" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </a>
                                                    @endcan
                                            </td>
                                        @endif
                                    @else
                                        @can('Show Ticket')
                                            <td>
                                                <a class="menu-link ms-3"
                                                    href="{{ route('assignedTicket.show', $ticket->id) }}">
                                                    <span class="menu-icon">
                                                        <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                        <span class="svg-icon svg-icon-2" style="fill: #1c0eb6">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                height="512" viewBox="0 0 24 24" version="1.1">
                                                                <path
                                                                    d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                                <circle cx="12" cy="12" r="4" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </a>
                                            </td>
                                        @endcan
                                @endif
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
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Pengajuan Perubahan Tugas Tiket
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <form action="{{ route('requestTicket.requestAssignTo', $ticket->id) }}" method="POST"
                        class="d-inline">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5>Apakah Anda yakin ingin mengajukan perubahan tugas Tiket ini?</h5>
                                    <small
                                        class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                    <br><br>
                                    {{ $ticket->no_ticket }}
                                    {{ $ticket->title }}
                                    <div class="mt-3">
                                        <label for="changed_assign_to">Di Alihkan Ke:</label>
                                        <select name="changed_assign_to" class="form-select mt-2" required>
                                            @foreach ($users as $user)
                                                <!-- pastikan $users tersedia di Blade -->
                                                <option value="{{ $user->id }}"
                                                    {{ $ticket->assign_to == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="approval_assign_to" value="1">
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <button class="btn btn-primary" type="submit">Ajukan</button>
                        </div><!--end modal-footer-->
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
