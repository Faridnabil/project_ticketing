@extends('layouts.dashboard.app')

@section('title')
    Ticket yang Belum Ditetapkan | PLN ICON+
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
                <div class="card-header">
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Pemilik</th>
                                    <th>Tetapkan Ke</th>
                                    <th>Prioritas</th>
                                    <th>Dibuat Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Pemilik</th>
                                    <th>Tetapkan Ke</th>
                                    <th>Prioritas</th>
                                    <th>Dibuat Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if ($tickets->count())
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->no_ticket }}</td>
                                            <td>{{ $ticket->title }}</td>
                                            <td>{{ $ticket->customers->name }}</td>
                                            <td>
                                                @if ($ticket->assignTo != null)
                                                    {{ $ticket->assignTo->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
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
                                            <td>
                                                @if ($ticket->status_id == '1')
                                                    <span class="badge"
                                                        style="background-color:red ; color: white; font-weight:bold">
                                                        Tertunda</span>
                                                @elseif($ticket->status_id == '2')
                                                    <span class="badge"
                                                        style="background-color:blue ; color: white; font-weight:bold">
                                                        Diterima</span>
                                                @elseif($ticket->status_id == '3')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                        Proses</span>
                                                @elseif($ticket->status_id == '4')
                                                    <span class="badge"
                                                        style="background-color:green ; color: white; font-weight:bold">
                                                        Selesai</span>
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold">
                                                        -</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('Show Ticket')
                                                    <a href="{{ route('unassignedTicket.show', $ticket->id) }}"
                                                        class="btn btn-success px-6 align-self-center text-nowrap mb-2">
                                                        Lihat
                                                    </a>
                                                @endcan
                                                @php
                                                    $existingRequest = App\Models\RequestAssignment::where(
                                                        'ticket_id',
                                                        $ticket->id,
                                                    )
                                                        ->where('user_id', Auth::id())
                                                        ->exists();
                                                @endphp
                                                @if (Auth::user()->hasRole('Tenaga Ahli') && $ticket->assign_to == null && !$existingRequest)
                                                    <button class="btn btn-primary px-6 align-self-center text-nowrap mb-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_request_{{ $ticket->id }}">
                                                        Ajukan Diri
                                                    </button>
                                                @endif
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
                            Form Ajukan Diri Menangani Tiket
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5>Apakah Anda yakin ingin menangani tiket ini?</h5>
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
                        <form action="{{ route('unassignedTicket.requestAssignment', $ticket->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            <button class="btn btn-primary" type="submit">Ajukan</button>
                        </form>
                    </div><!--end modal-footer-->
                </div>
            </div>
        </div>
    @endforeach
@endsection
