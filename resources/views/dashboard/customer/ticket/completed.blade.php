@extends('layouts.dashboard.app')

@section('title')
    Riwayat Tiket | PLN Icon+
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Riwayat Tiket
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Riwayat Tiket</small>
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
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->

                    <!--end::Card toolbar-->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Riwayat Tiket</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor Tiket</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tetapkan Ke</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tickets->count())
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->no_ticket }}</td>
                                                <td>{{ $ticket->title }}</td>
                                                <td>{{ $ticket->category->category_name }}</td>
                                                <td>
                                                    @if ($ticket->assign_to != null)
                                                        {{ $ticket->assignTo->name }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ date('d F Y', strtotime($ticket->created_at)) }}</td>
                                                <td>{{ date('d F Y', strtotime($ticket->updated_at)) }}</td>
                                                <td>
                                                    <span class="badge"
                                                        style="background-color:green; color: white; font-weight:bold">Selesai</span>
                                                </td>
                                                <td class="actions text-center">
                                                    @can('Show Ticket')
                                                        <a href="{{ route('myTicket.show', $ticket->id) }}"
                                                            class="btn btn-icon btn-round btn-success mb-1">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
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
                            <form action="{{ route('myTicket.destroy', $ticket->id) }}" method="POST" class="d-inline">
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
