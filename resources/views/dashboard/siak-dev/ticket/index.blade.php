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
                    <div class="card-title">
                        <!--begin::Form-->
                        <form method="GET" action="{{ route('siakDev.ticket.index') }}" class="d-flex">
                            <select name="level" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Disposisi">
                                <option></option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;

                            <select name="category_id" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Kategori">
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;

                            <select name="priority_id" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Prioritas">
                                <option></option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->priority_name }}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;

                            <select name="status_id" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Status">
                                <option></option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;

                            <button type="submit" class="btn btn-primary me-1">Filter</button>
                            <a href="{{ route('siakDev.ticket.index') }}" class="btn btn-danger">Reset</a>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table id="kt_datatable_example_5"
                        class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">Nomor Tiket</th>
                                <th class="min-w-70px">Kategori</th>
                                {{-- <th class="min-w-70px">Pemilik</th> --}}
                                <th class="min-w-70px">Disposisi</th>
                                <th class="min-w-70px">Prioritas</th>
                                <th class="min-w-70px">Dibuat Tanggal</th>
                                <th class="min-w-70px">Status</th>
                                <th class="min-w-70px">Aksi</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @if ($tickets->count())
                                @foreach ($tickets as $ticket)
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Nomor Ticket=-->
                                        <td>
                                            {{ $ticket->no_ticket }}
                                        </td>
                                        <!--end::Nomor Ticket=-->
                                        <!--begin::Title=-->
                                        <td>
                                            {{ $ticket->category->category_name }}
                                        </td>
                                        <!--end::Title=-->
                                        <!--begin::Assign To=-->
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
                                                <span class="badge"
                                                    style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">
                                                    -
                                                </span>
                                            @endif
                                        </td>

                                        <!--end::Assign To=-->
                                        <!--begin::Priority=-->
                                        <td>
                                            @if ($ticket->priority_id == '4')
                                                <span class="badge"
                                                    style="background-color:red ; color: white; font-weight:bold">
                                                    Critical</span>
                                            @elseif($ticket->priority_id == '3')
                                                <span class="badge"
                                                    style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                    High</span>
                                            @elseif($ticket->priority_id == '2')
                                                <span class="badge"
                                                    style="background-color:blue ; color: white; font-weight:bold">
                                                    Medium</span>
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
                                        <!--end::Priority=-->
                                        <!--begin::Payment method=-->
                                        <td>
                                            {{ date('d F Y', strtotime($ticket->created_at)) }}
                                        </td>
                                        <!--end::Payment method=-->
                                        <!--begin::Date=-->
                                        <td>
                                            <div class="d-flex align-items-center">
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
                                                        Selesai
                                                    </span>
                                                @elseif($ticket->status_id == '5')
                                                    <span class="badge"
                                                        style="background-color:rgb(185, 192, 2) ; color: white; font-weight:bold">
                                                        Buka Kembali
                                                    </span>
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold">
                                                        -</span>
                                                @endif
                                                @if (($ticket->status && $ticket->status_id == '2') || $ticket->status_id == '3' || $ticket->status_id == '5')
                                                    <form action="{{ route('siakDev.tickets.statusTicket', $ticket->id) }}"
                                                        method="POST" id="statusForm_{{ $ticket->id }}">
                                                        @csrf
                                                        <div class="custom-select-wrapper">
                                                            <select name="status_id" class="custom-select"
                                                                id="statusSelect_{{ $ticket->id }}">
                                                                <option value="2"
                                                                    {{ $ticket->status_id == '2' ? 'selected' : '' }}>
                                                                    Diterima</option>
                                                                <option value="3"
                                                                    {{ $ticket->status_id == '3' ? 'selected' : '' }}>
                                                                    Proses</option>
                                                                <option value="4"
                                                                    {{ $ticket->status_id == '4' ? 'selected' : '' }}>
                                                                    Selesai</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                        <!--begin::Action=-->
                                        <td>
                                            @if (($ticket->status && $ticket->status_id == '2') || $ticket->status_id == '3' || $ticket->status_id == '5')
                                                @can('Edit Ticket')
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('siakDev.ticket.edit', $ticket->id) }}" type="button"
                                                        title="Ubah Tiket">
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
                                                        data-bs-target="#kt_modal_ticket_{{ $ticket->id }}"
                                                        title="Hapus Tiket">
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
                                                @can('Show Ticket')
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('siakDev.ticket.show', $ticket->id) }}" type="button"
                                                        title="Lihat Tiket">
                                                        <span class="menu-icon" style="fill: #1218ca">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                    height="512" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                                    <circle cx="12" cy="12" r="4" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('Send Ticket')
                                                    @if ($ticket->level4 && $ticket->level5)
                                                    @else
                                                        <a class="menu-link ms-3" href="" type="button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_ticket2_{{ $ticket->id }}"
                                                            title="Pengajuan Tiket">
                                                            <span class="menu-icon" style="fill: #0d8987">
                                                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                        height="512" viewBox="0 0 24 24" version="1.1">
                                                                        <path
                                                                            d="M23.017,8.785c-.595-.542-1.364-.816-2.168-.782-.804,.038-1.544,.387-2.086,.981l-3.216,3.534c-.551-.909-1.55-1.519-2.689-1.519H3c-1.654,0-3,1.346-3,3v7c0,1.654,1.346,3,3,3H13.448l9.788-10.985c1.093-1.227,.994-3.124-.219-4.229Zm-1.274,2.899l-9.191,10.315H3c-.551,0-1-.448-1-1v-7c0-.552,.449-1,1-1H12.858c.63,0,1.142,.513,1.142,1.143,0,.564-.421,1.051-.981,1.13l-5.161,.737,.283,1.98,5.16-.737c1.175-.168,2.13-.987,2.515-2.059l4.426-4.864c.182-.199,.43-.316,.7-.329,.274-.016,.528,.081,.728,.263,.407,.371,.44,1.009,.073,1.421ZM15,2.5c0-1.379-1.122-2.5-2.5-2.5H5.5c-1.378,0-2.5,1.121-2.5,2.5v6.5H15V2.5Zm-2,4.5H5V2.5c0-.275,.224-.5,.5-.5h7c.276,0,.5,.225,.5,.5V7ZM7,3h4v2H7V3Z" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </a>
                                                    @endif
                                                @endcan
                                            @else
                                                @can('Show Ticket')
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('siakDev.ticket.show', $ticket->id) }}" type="button"
                                                        title="Lihat Tiket">
                                                        <span class="menu-icon" style="fill: #1218ca">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                    height="512" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,18a6,6,0,1,1,6-6A6.006,6.006,0,0,1,12,18Z" />
                                                                    <circle cx="12" cy="12" r="4" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                @endcan
                                            @endif
                                        </td>
                                        <!--end::Action=-->
                                    </tr>
                                    <!--end::Table row-->
                                @endforeach
                            @endif
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
                        <form action="{{ route('siakDev.ticket.destroy', $ticket->id) }}" method="POST"
                            class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </div><!--end modal-footer-->
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="kt_modal_ticket2_{{ $ticket->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Pengalihan Tiket Ke Pejabat
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <form action="{{ route('siakDev.tickets.send', $ticket->id) }}" method="POST" class="d-inline">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5>Apakah Anda yakin tugas Tiket ini dialihkan kepada Pejabat?</h5>
                                    <small
                                        class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                    <br><br>
                                    <style>
                                        .ticket-details {
                                            font-family: Arial, sans-serif;
                                            margin: 20px;
                                            padding: 20px;
                                            border: 1px solid #ccc;
                                            border-radius: 8px;
                                            background-color: #f9f9f9;
                                        }

                                        .ticket-details h3 {
                                            font-size: 1.5em;
                                            color: #333;
                                            margin-bottom: 20px;
                                        }

                                        .ticket-details .info {
                                            font-size: 1em;
                                            color: #555;
                                            line-height: 1.6em;
                                        }

                                        .ticket-details .info span {
                                            font-weight: bold;
                                        }

                                        .ticket-details hr {
                                            margin: 20px 0;
                                            border: 0;
                                            border-top: 1px solid #ccc;
                                        }
                                    </style>

                                    <div class="ticket-details">
                                        <h3>{{ $ticket->no_ticket }}</h3>
                                        <p class="info">
                                            <span>Kategori:</span> {{ $ticket->category->category_name }}<br>
                                            <span>Status:</span> {{ $ticket->status->status_name }}<br>
                                            <span>Prioritas:</span> {{ $ticket->priority->priority_name }}<br>
                                            <span>Nama Provinsi:</span> {{ $ticket->province->province_name }}<br>
                                            <span>Nama Kota:</span> {{ $ticket->cityOrRegency->city_or_regency_name }}
                                        </p>

                                        <hr>

                                        <p class="info">
                                            <span>Nama PIC:</span> {{ $ticket->jabatan }} {{ $ticket->pic }}<br>
                                            <span>Nomor Telpon:</span> {{ $ticket->no_hp }}<br>
                                        </p>
                                    </div>

                                    <input type="hidden" name="level1" value="">
                                    <input type="hidden" name="level2" value="">
                                    <input type="hidden" name="level3" value="">
                                    <input type="hidden" name="level4" value="">

                                    <select name="level5" hidden required>
                                        @foreach ($pejabatUsers as $roleId)
                                            <option value="{{ $roleId }}">{{ $roleId }}</option>
                                        @endforeach
                                    </select>

                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>

                            <button type="submit" class="btn btn-success">Kirim Tiket</button>
                        </div><!--end modal-footer-->
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="confirmModal_{{ $ticket->id }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Perubahan Status</h5>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin mengubah status ticket ini menjadi <span
                            id="status-name-{{ $ticket->id }}"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmButton_{{ $ticket->id }}">Ya, Ubah
                            Status</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('statusSelect_{{ $ticket->id }}').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let statusName = selectedOption.text;
                let statusForm = document.getElementById('statusForm_{{ $ticket->id }}');

                // Set status name in modal
                document.getElementById('status-name-{{ $ticket->id }}').textContent = statusName;

                // Show modal
                $('#confirmModal_{{ $ticket->id }}').modal('show');

                // On confirm button click
                document.getElementById('confirmButton_{{ $ticket->id }}').onclick = function() {
                    statusForm.submit();
                };
            });
        </script>
    @endforeach
@endsection
