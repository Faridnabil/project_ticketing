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
                <div class="card-header">
                    <h4 class="card-title">Data Tiket Selesai</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('department.tickets.export') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" class="form-control" id="start_date">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" class="form-control" id="end_date">
                            </div>
                            <div class="col-md-3">
                                <label for="status_id">Status</label>
                                <select name="status_id" class="form-control" id="status_id">
                                    <option value="">Pilih Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Export to Excel</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Pemilik</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Prioritas</th>
                                    <th>Deskripsi</th>
                                    <th>Solusi</th>
                                    <th>Tanggal Dikirim</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tickets->count())
                                    @foreach ($tickets as $ticket)
                                        @if ($ticket->status_id == 4) <!-- Selesai -->
                                            <tr>
                                                <td>{{ $ticket->no_ticket }}</td>
                                                <td>{{ $ticket->customers->name }}</td>
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
                                                <td>{{ $ticket->description }}</td>
                                                <td>{{ $ticket->solution }}</td>
                                                <td>{{ date('d F Y', strtotime($ticket->created_at)) }}</td>
                                                <td>{{ date('d F Y', strtotime($ticket->updated_at)) }}</td>
                                                <td>
                                                    @can('Show Ticket')
                                                        <a href="{{ route('assignedTicket.show', $ticket->id) }}"
                                                            class="btn btn-success px-6 align-self-center text-nowrap mb-2">
                                                            Lihat
                                                        </a>
                                                    @endcan
                                                    @if (in_array($ticket->status_id, [2, 3])) <!-- Diterima dan Proses -->
                                                        @can('Edit Ticket')
                                                            <a href="{{ route('assignedTicket.edit', $ticket->id) }}"
                                                                class="btn btn-primary px-6 align-self-center text-nowrap mb-2">
                                                                Ubah
                                                            </a>
                                                        @endcan
                                                    @endif
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
