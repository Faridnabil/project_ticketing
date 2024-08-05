@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Tiket</small>
                </h1>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card mb-3">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h6 class="m-0 font-weight-bold text-dark">Masukan Tanggal Awal dan Akhir</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('helpdesk.report.index') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-4 mt-3">Tanggal Awal</label>
                                    <input type="date" name="awal" required class="form-control" value="{{ $req1 }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-4 mt-3">Tanggal Akhir</label>
                                    <input type="date" name="akhir" required class="form-control" value="{{ $req2 }}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Masukan Data">
                    </form>
                    <br>
                </div>
            </div>

            @if (isset($tickets))
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                        <form action="{{ route('helpdesk.report.export') }}" method="get">
                            <input type="hidden" name="awal" value="{{ $req1 }}">
                            <input type="hidden" name="akhir" value="{{ $req2 }}">
                            <button type="submit" class="btn mb-4" style="background-color: #17ba4b;color:white">
                                <span class="img-icon">
                                    <img src="{{ asset('template/dist/assets/media/illustrations/office365.png')}}" alt="Export Icon" width="24" height="24">
                                </span>
                                Export
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table id="kt_datatable_example_5" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                        <thead>
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">Nomor Tiket</th>
                                <th class="min-w-70px">Kategori</th>
                                <th class="min-w-70px">Disposisi</th>
                                <th class="min-w-70px">Prioritas</th>
                                <th class="min-w-70px">Dibuat Tanggal</th>
                                <th class="min-w-70px">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @if (isset($hitung) && $hitung == 0)
                                <tr>
                                    <td colspan="6" class="text-center">No tickets found for the selected date range.</td>
                                </tr>
                            @else
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->no_ticket }}</td>
                                        <td>{{ $ticket->category->category_name }}</td>
                                        <td>
                                            @if ($ticket->level1 != null)
                                                {{ $ticket->helpdesk->name }}
                                            @elseif ($ticket->level2 != null)
                                                {{ $ticket->koordinator->name }}
                                            @elseif ($ticket->level3 != null)
                                                {{ $ticket->staffSubdit->name }}
                                            @elseif ($ticket->level4 != null)
                                                {{ $ticket->siakDev->name }}
                                            @elseif ($ticket->level5 != null)
                                                {{ $ticket->pejabat->name }}
                                            @else
                                                <span class="badge" style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ticket->priority_id == '4')
                                                <span class="badge" style="background-color:red; color: white; font-weight:bold">Critical</span>
                                            @elseif($ticket->priority_id == '3')
                                                <span class="badge" style="background-color:#FF7F3E; color: white; font-weight:bold">High</span>
                                            @elseif($ticket->priority_id == '2')
                                                <span class="badge" style="background-color:blue; color: white; font-weight:bold">Medium</span>
                                            @elseif($ticket->priority_id == '1')
                                                <span class="badge" style="background-color:green; color: white; font-weight:bold">Low</span>
                                            @else
                                                <span class="badge" style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d F Y', strtotime($ticket->created_at)) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($ticket->status_id == '1')
                                                    <span class="badge" style="background-color:red; color: white; font-weight:bold">Tertunda</span>
                                                @elseif($ticket->status_id == '2')
                                                    <span class="badge" style="background-color:blue; color: white; font-weight:bold">Diterima</span>
                                                @elseif($ticket->status_id == '3')
                                                    <span class="badge" style="background-color:#FF7F3E; color: white; font-weight:bold">Proses</span>
                                                @elseif($ticket->status_id == '4')
                                                    <span class="badge" style="background-color:green; color: white; font-weight:bold">Selesai</span>
                                                @elseif($ticket->status_id == '5')
                                                    <span class="badge" style="background-color:rgb(185, 192, 2); color: white; font-weight:bold">Buka Kembali</span>
                                                @else
                                                    <span class="badge" style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
