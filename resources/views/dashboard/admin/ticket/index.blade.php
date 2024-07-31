@extends('layouts.dashboard.app')

@section('title')
    Ticket | PLN Icon+
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Semua Tiket</h4>
                    <div class="d-flex align-items-center">
                        @can('Create Ticket')
                            <a href="{{ route('ticket.create') }}" class="btn btn-primary btn-sm me-2">
                                <span class="btn-label">
                                    <i class="fas fa-plus"></i>
                                </span>
                                Tambah Tiket
                            </a>
                        @endcan
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            <span class="btn-label">
                                <i class="fas fa-filter"></i>
                            </span>
                            Filter
                        </button>
                        <a href="{{ route('ticket.export', request()->query()) }}" class="btn btn-sm ms-2"
                            style="background-color: #17ba4b; color:white">
                            <span class="btn-label">
                                <i class="fas fa-file-excel"></i>
                            </span>
                            Export
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Kategori</th>
                                    <th>Pemilik</th>
                                    <th>Tetapkan Ke</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th style="width: 300px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tickets->count())
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->no_ticket }}</td>
                                            <td>{{ $ticket->category->category_name }}</td>
                                            <td>{{ $ticket->customers->name }}</td>
                                            <td class="text-center">
                                                @if ($ticket->assignTo != null)
                                                    {{ $ticket->assignTo->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($ticket->priority_id == '4')
                                                    <span class="badge"
                                                        style="background-color:red; color: white; font-weight:bold">Critical</span>
                                                @elseif($ticket->priority_id == '3')
                                                    <span class="badge"
                                                        style="background-color:blue; color: white; font-weight:bold">Medium</span>
                                                @elseif($ticket->priority_id == '2')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E; color: white; font-weight:bold">High</span>
                                                @elseif($ticket->priority_id == '1')
                                                    <span class="badge"
                                                        style="background-color:green; color: white; font-weight:bold">Low</span>
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($ticket->status_id == '1')
                                                    <span class="badge"
                                                        style="background-color:red; color: white; font-weight:bold">Tertunda</span>
                                                @elseif($ticket->status_id == '2')
                                                    <span class="badge"
                                                        style="background-color:blue; color: white; font-weight:bold">Diterima</span>
                                                @elseif($ticket->status_id == '3')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E; color: white; font-weight:bold">Proses</span>
                                                @elseif($ticket->status_id == '4')
                                                    <span class="badge"
                                                        style="background-color:green; color: white; font-weight:bold">Selesai</span>
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('Show Ticket')
                                                    <a class="menu-link ms-3" href="{{ route('ticket.show', $ticket->id) }}"
                                                        type="button">
                                                        <span class="menu-icon" style="fill: #1218ca">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                                    <circle cx="12" cy="12" r="4" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('Edit Ticket')
                                                    <a class="menu-link ms-3" href="{{ route('ticket.edit', $ticket->id) }}"
                                                        type="button">
                                                        <span class="menu-icon" style="fill: #bd6710">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
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
                                                @can('Delete Ticket')
                                                    <a class="menu-link ms-3" href="#" type="reset"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_ticket_{{ $ticket->id }}">
                                                        <span class="menu-icon" style="fill: #e21414">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="M23,3H18V2.5A2.5,2.5,0,0,0,15.5,0h-7A2.5,2.5,0,0,0,6,2.5V3H1V6H3V21a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V6h2ZM18,21H6V6H18Z" />
                                                                    <rect x="8" y="9" width="3" height="9" />
                                                                    <rect x="13" y="9" width="3" height="9" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                @endcan
                                            </td>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" method="GET" action="{{ route('ticket.index') }}"
                        class="d-flex flex-wrap justify-content-between">
                        <div class="col-md-6">
                            <label for="assign_to" class="form-label">Tenaga Ahli</label>
                            <select name="assign_to" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Tenaga Ahli">
                                <option value="">Pilih Tenaga Ahli </option>
                                @foreach ($assign_to as $assign)
                                    <option value="{{ $assign->id }}">{{ $assign->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select" data-control="select2"
                                data-placeholder="Pilih Kategori">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="priority_id" class="form-label">Prioritas</label>
                            <select name="priority_id" id="priority_id" class="form-select" data-control="select2"
                                data-placeholder="Pilih Prioritas">
                                <option value="">Pilih Prioritas</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->priority_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status_id" class="form-label">Status</label>
                            <select name="status_id" id="status_id" class="form-select" data-control="select2"
                                data-placeholder="Pilih Status">
                                <option value="">Pilih Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                placeholder="Tanggal Mulai">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                placeholder="Tanggal Akhir">
                        </div>
                        <div class="d-flex align-self-end mt-2">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('ticket.index') }}" class="btn btn-danger" style="color: white">Hapus</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Filter Modal -->

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
                                <small
                                    class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                <ul class="mt-3 mb-0">
                                    <li>{{ $ticket->no_ticket }}</li>
                                    <li>{{ $ticket->title }}</li>
                                </ul>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                        </form>
                    </div><!--end modal-footer-->
                </div>
            </div>
        </div>
    @endforeach
@endsection
