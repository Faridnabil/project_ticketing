@extends('layouts.dashboard.app')

@section('title')
    Ticket | PLN Icon+
@endsection
@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Tiket yang Ditugaskan</h4>
                    <div class="d-flex align-items-center">
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
                                    <th>Layanan</th>
                                    <th>Pemilik</th>
                                    <th>Tetapkan Ke</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tickets->count())
                                    @foreach ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->no_ticket }}</td>
                                                <td>{{ $ticket->category->category_name }}</td>
                                                <td>{{ $ticket->service->service_name }}</td>
                                                <td>{{ $ticket->name }}</td>
                                                <td class="text-center">{{ $ticket->assignTo->name }}</td>
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
                                                            style="background-color:rgb(6, 240, 6); color: white; font-weight:bold">Aktif</span>
                                                    @elseif($ticket->status_id == '3')
                                                        <span class="badge"
                                                            style="background-color:#FF7F3E; color: white; font-weight:bold">Proses</span>
                                                    @elseif($ticket->status_id == '4')
                                                        <span class="badge"
                                                            style="background-color:rgb(0, 107, 0); color: white; font-weight:bold">Selesai</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td style="width: 150px;  align-items: center; justify-content: center;">
                                                    <a class="menu-link ms-3" href="{{ route('engineerticket.show', $ticket->id) }}" type="button">
                                                        <span class="menu-icon" style="fill: #1218ca">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                                    <circle cx="12" cy="12" r="4" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                    {{-- @can('Edit Ticket')
                                                        <a class="menu-link ms-3" href="{{ route('ticket.edit', $ticket->id) }}" type="button">
                                                            <span class="menu-icon" style="fill: #bd6710">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <path d="M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z" />
                                                                        <path d="M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z" />
                                                                    </svg>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    @endcan --}}
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

    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-4" method="GET" action="{{ route('engineerticket.index') }}"
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
                            <a href="{{ route('engineerticket.index') }}" class="btn btn-danger" style="color: white">Hapus</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
