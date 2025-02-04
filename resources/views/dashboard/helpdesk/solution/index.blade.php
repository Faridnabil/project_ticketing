@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
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
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="d-flex align-items-center gap-3">
                        <!-- Form Filter -->
                        <form method="GET" action="{{ route('helpdesk.solution.index') }}"
                            class="d-flex align-items-center gap-2">
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">

                            <select name="category_id" id="kategori" class="form-select" data-control="select2"
                                data-placeholder="Pilih Kategori">
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('helpdesk.solution.index') }}" class="btn btn-danger" style="width: 80%"F>Atur
                                ulang</a>
                        </form>

                        <!-- Form Export (Pisah dari Form Filter) -->
                        <form action="{{ route('helpdesk.reportNoted.export') }}" method="GET">
                            <button type="submit" class="btn btn-success d-flex align-items-center">
                                <img src="{{ asset('template/dist/assets/media/illustrations/office365.png') }}"
                                    alt="Export Icon" width="24" height="24" class="me-2">
                                Export
                            </button>
                        </form>
                    </div>

                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <table id="kt_datatable_example_5"
                        class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">No</th>
                                <th class="min-w-70px">Kategori</th>
                                <th class="min-w-70px">Catatan</th>
                                <th class="min-w-70px">Diselesaikan Tanggal</th>
                                <th class="min-w-100px">Aksi</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            {{-- @if (request('tanggal_mulai') || request('tanggal_selesai') || request('level') || request('category_id') || request('priority_id') || request('status_id') || request('city_or_regency_id') || request('province_id')) --}}
                            @foreach ($tickets as $ticket)
                                <!--begin::Table row-->
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $ticket->category->category_name }}
                                    </td>

                                    <td>{!! Str::limit($ticket->completion_notes, 150) !!}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($ticket->updated_at)->locale('id')->translatedFormat('d F Y') }}
                                    </td>

                                    <td>
                                        @can('Show Ticket')
                                            <!-- Trigger Modal Button -->
                                            <a class="menu-link ms-3" href="#" data-bs-toggle="modal"
                                                data-bs-target="#PreviewNoted-{{ $ticket->id }}" type="button">
                                                <span class="menu-icon" style="fill: #1218ca">
                                                    <!--begin::Svg Icon-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512"
                                                            viewBox="0 0 24 24" version="1.1">
                                                            <path
                                                                d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                            <circle cx="12" cy="12" r="4" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        @endcan

                                        <!-- Modal for each ticket -->
                                        <div class="modal fade" id="PreviewNoted-{{ $ticket->id }}" tabindex="-1"
                                            aria-labelledby="PreviewNotedLabel-{{ $ticket->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <!-- Center the modal vertically -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="PreviewNotedLabel-{{ $ticket->id }}">
                                                            Detail Catatan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Display completion_notes for the current ticket -->
                                                        {!! nl2br($ticket->completion_notes) !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!--end::Action=-->
                                </tr>
                                <!--end::Table row-->
                            @endforeach
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
                        <form action="{{ route('helpdesk.ticket.destroy', $ticket->id) }}" method="POST"
                            class="d-inline">
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
