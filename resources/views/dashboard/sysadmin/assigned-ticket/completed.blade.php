@extends('layouts.dashboard.app')

@section('title')
    Tiket Selesai | PLN Icon+
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket Selesai
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Tiket yang Selesai</small>
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
                    <h4 class="card-title">Data Tiket Selesai</h4>
                    <form action="{{ route('sysadmin.tickets.export') }}" method="GET" class="d-flex mb-0">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <label for="start_date" class="form-label mb-0">Start Date</label>
                                <input type="date" name="start_date" class="form-control form-control-sm"
                                    id="start_date">
                            </div>
                            <div class="me-2">
                                <label for="end_date" class="form-label mb-0">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" id="end_date">
                            </div>
                            <div class="d-flex align-items-end mt-4">
                                <button type="submit" class="btn btn-sm" style="background-color: #17ba4b; color:white">
                                    <span class="btn-label">
                                        <i class="fas fa-file-excel"></i>
                                    </span>
                                    Export
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Pemilik</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Prioritas</th>
                                    <th>Tanggal Dikirim</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tickets->count())
                                    @foreach ($tickets as $ticket)
                                        @if ($ticket->status_id == 4)
                                            <!-- Selesai -->
                                            <tr>
                                                <td>{{ $ticket->no_ticket }}</td>
                                                <td>{{ $ticket->user_s->name }}</td>
                                                <td>{{ $ticket->title }}</td>
                                                <td>{{ $ticket->category->category_name }}</td>
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
                                                <td>{{ date('d F Y', strtotime($ticket->created_at)) }}</td>
                                                <td>{{ date('d F Y', strtotime($ticket->updated_at)) }}</td>
                                                <td class="text-center">
                                                    @can('Show Ticket')
                                                        <a href="{{ route('assignedSysadmin.show', $ticket->id) }}"
                                                            class="menu-link" title="Lihat">
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
                                                    {{-- @if (in_array($ticket->status_id, [2, 3]))
                                                        <!-- Diterima dan Proses -->
                                                        @can('Edit Ticket')
                                                            <a href="{{ route('assignedTicket.edit', $ticket->id) }}"
                                                                class="btn btn-primary px-6 align-self-center text-nowrap mb-2">
                                                                Ubah
                                                            </a>
                                                        @endcan
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @endif
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
