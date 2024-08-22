@extends('layouts.dashboard.app')

@section('title')
    Verifikasi Tiket | PLN Icon+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <!--begin::Card-->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Verifikasi Tiket</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Pemilik</th>
                                    <th>Kategori</th>
                                    <th>Prioritas</th>
                                    <th>Dibuat Tanggal</th>
                                    <th>Status Verifikasi</th>
                                    <th style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tickets->count())
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->no_ticket }}</td>
                                            <td>{{ $ticket->title }}</td>
                                            <td>{{ $ticket->name }}</td>
                                            <td>{{ $ticket->category->category_name }}</td>
                                            <td>
                                                @if ($ticket->priority_id == '4')
                                                    <span class="badge"
                                                        style="background-color:red ; color: white; font-weight:bold">
                                                        Critical</span>
                                                @elseif($ticket->priority_id == '3')
                                                    <span class="badge"
                                                        style="background-color:blue ; color: white; font-weight:bold">
                                                        Medium</span>
                                                @elseif($ticket->priority_id == '2')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                        High</span>
                                                @elseif($ticket->priority_id == '1')
                                                    <span class="badge"
                                                        style="background-color:green ; color: white; font-weight:bold">
                                                        Low</span>
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold">
                                                        -</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d F Y', strtotime($ticket->created_at)) }}</td>
                                            <td>{{ $ticket->status }}</td>
                                            <td>
                                                @can('Show Ticket')
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('unassignedSyasadmin.show', $ticket->id) }}"
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
                                                    <a href="{{ route('unassignedSysadmin.edit', $ticket->id) }}" title="Edit"
                                                        class="menu-link ms-3">
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
                                                <a class="menu-link ms-3" href="#" type="reset"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_request_{{ $ticket->id }}">
                                                    <span class="menu-icon" style="fill: #0d8987">
                                                        <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <path
                                                                    d="M23.017,8.785c-.595-.542-1.364-.816-2.168-.782-.804,.038-1.544,.387-2.086,.981l-3.216,3.534c-.551-.909-1.55-1.519-2.689-1.519H3c-1.654,0-3,1.346-3,3v7c0,1.654,1.346,3,3,3H13.448l9.788-10.985c1.093-1.227,.994-3.124-.219-4.229Zm-1.274,2.899l-9.191,10.315H3c-.551,0-1-.448-1-1v-7c0-.552,.449-1,1-1H12.858c.63,0,1.142,.513,1.142,1.143,0,.564-.421,1.051-.981,1.13l-5.161,.737,.283,1.98,5.16-.737c1.175-.168,2.13-.987,2.515-2.059l4.426-4.864c.182-.199,.43-.316,.7-.329,.274-.016,.528,.081,.728,.263,.407,.371,.44,1.009,.073,1.421ZM15,2.5c0-1.379-1.122-2.5-2.5-2.5H5.5c-1.378,0-2.5,1.121-2.5,2.5v6.5H15V2.5Zm-2,4.5H5V2.5c0-.275,.224-.5,.5-.5h7c.276,0,.5,.225,.5,.5V7ZM7,3h4v2H7V3Z" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
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

        <!-- Modal Ajukan Diri -->
        <div class="modal fade" tabindex="-1" id="kt_modal_request_{{ $ticket->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title m-0 text-white" id="exampleModalRequest1">
                            Verifikasi Tiket
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5>Apakah tiket diverifikasi atau ditolak?</h5>
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
                        <form action="{{ route('unassignedSysadmin.verifyTicket', $ticket->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary" type="submit">Verifikasi</button>
                        </form>
                        <form action="{{ route('unassignedSysadmin.rejectTicket', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">
                                Tolak
                            </button>
                        </form>
                    </div><!--end modal-footer-->
                </div>
            </div>
        </div>
    @endforeach
@endsection
