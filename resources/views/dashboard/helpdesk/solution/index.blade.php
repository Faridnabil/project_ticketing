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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Solusi Teknis
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Solusi Teknis</small>
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
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Form-->
                        <form method="GET" action="{{ route('helpdesk.solution.index') }}"
                            class="d-flex align-items-center flex-wrap gap-3">

                            <!-- Filter Tanggal Mulai -->
                            <div class="position-relative">
                                <input type="date" id="start_date" name="start_date" class="form-control w-150px"
                                    style="border: 1px solid #28a745;"
                                    value="{{ old('start_date', request('start_date')) }}"
                                    placeholder="Tanggal Mulai">
                            </div>

                            <!-- Filter Tanggal Akhir -->
                            <div class="position-relative">
                                <input type="date" id="end_date" name="end_date" class="form-control w-150px"
                                    style="border: 1px solid #dc3545;"
                                    value="{{ old('end_date', request('end_date')) }}"
                                    placeholder="Tanggal Akhir">
                            </div>

                            <!-- Filter Kategori -->
                            <div class="w-200px">
                                <select name="category_id" id="category_id" class="form-select" data-control="select2"
                                    data-placeholder="Pilih Kategori">
                                    <option></option>
                                    <option value="all" {{ request('category_id') == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex align-items-center gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <button type="button" id="resetBtn" class="btn btn-danger">Atur ulang</button>
                                <!-- Export Button -->
                        <form action="{{ route('helpdesk.reportNoted.export') }}" method="GET">
                            <button type="submit" class="btn btn-success d-flex align-items-center">
                                <img src="{{ asset('template/dist/assets/media/illustrations/office365.png') }}"
                                    alt="Export Icon" width="24" height="24" class="me-2">
                                Export
                            </button>
                        </form>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card title-->

                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                     <table id="kt_datatable_example_1" class="table table-row-bordered gy-5">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">No</th>
                                <th class="min-w-70px">Nomor Tiket</th>
                                <th class="min-w-70px">Kategori</th>
                                <th class="min-w-70px">Prioritas</th>
                                <!-- <th class="min-w-70px">Solusi</th> -->
                                <th class="min-w-70px">Diselesaikan Tanggal</th>
                                <th class="min-w-100px">Aksi</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <tbody class="text-black-600 fw-bold">
                            @foreach ($tickets as $ticket)
                                <!--begin::Table row-->
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $ticket->no_ticket }}
                                    </td>
                                    <td>
                                        {{ $ticket->category->category_name }}
                                    </td>

                                    <td>
                                        @if ($ticket->priority_id == '4')
                                            <span class="badge"
                                                style="background-color:red; color:white; font-weight:bold;">
                                                {{ $ticket->priority->priority_name }}
                                            </span>
                                        @elseif($ticket->priority_id == '3')
                                            <span class="badge"
                                                style="background-color:#FF7F3E; color:white; font-weight:bold;">
                                                {{ $ticket->priority->priority_name }}
                                            </span>
                                        @elseif($ticket->priority_id == '2')
                                            <span class="badge"
                                                style="background-color:blue; color:white; font-weight:bold;">
                                                {{ $ticket->priority->priority_name }}
                                            </span>
                                        @elseif($ticket->priority_id == '1')
                                            <span class="badge"
                                                style="background-color:green; color:white; font-weight:bold;">
                                                {{ $ticket->priority->priority_name }}
                                            </span>
                                        @else
                                            <span class="badge"
                                                style="background-color:rgb(77, 75, 75); color:white; font-weight:bold;">
                                                -
                                            </span>
                                        @endif
                                    </td>
                                    <!-- <td>{!! Str::limit($ticket->completion_notes, 150) !!}</td> -->
                                    <td>
                                        {{ \Carbon\Carbon::parse($ticket->updated_at)->locale('id')->translatedFormat('d F Y') }}
                                    </td>

                                    <td>
                                        @can('Edit Ticket')
                                            <a class="menu-link ms-3" href="{{ route('helpdesk.solution.edit', $ticket->id) }}"
                                                type="button">
                                                <span class="menu-icon" style="fill: #bd6710" title="Ubah Tiket">
                                                    <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                            viewBox="0 0 24 24" version="1.1">
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

                                        @can('Show Ticket')
                                            <!-- Trigger Modal Button -->
                                            <a class="menu-link ms-3" href="{{ route('helpdesk.tickets.solution', $ticket->id) }}" type="button">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetBtn = document.getElementById('resetBtn');

            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Reset semua input field
                document.getElementById('category_id').value = '';
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';

                // Reset Select2 jika ada
                const categorySelect = $('[name="category_id"]');
                if (categorySelect.length && categorySelect.data('select2')) {
                    categorySelect.val('').trigger('change');
                }
            });
        });
    </script>
@endsection
