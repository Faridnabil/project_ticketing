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
                        <form method="GET" action="{{ route('staffSubdit.ticket.index') }}" id="filterForm" class="d-flex align-items-center gap-2">
                            <select name="level" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Disposisi">
                                <option value="all" {{ request('level') == 'all' ? 'selected' : '' }}>Semua Disposisi</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}" {{ request('level') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                @endforeach
                            </select>

                            <select name="category_id" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Kategori">
                                <option value="all" {{ request('category_id') == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>

                            <select name="priority_id" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Prioritas">
                                <option value="all" {{ request('priority_id') == 'all' ? 'selected' : '' }}>Semua Prioritas</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}" {{ request('priority_id') == $priority->id ? 'selected' : '' }}>{{ $priority->priority_name }}</option>
                                @endforeach
                            </select>

                            <select name="status_id" class="form-select me-2" data-control="select2"
                                data-placeholder="Pilih Status">
                                <option value="all" {{ request('status_id') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->status_name }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary me-1">Tampilkan</button>
                            <button type="button" id="resetButton" class="btn btn-danger">Atur Ulang</button>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table id="kt_datatable_example_1" class="table table-row-bordered gy-5">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">Nomor Tiket</th>
                                <th class="min-w-70px">Kategori</th>
                                {{-- <th class="min-w-70px">Pemilik</th> --}}
                                <th class="min-w-70px">Disposisi</th>
                                <th class="min-w-70px">Prioritas</th>
                                <th class="min-w-70px">Permasalahan</th>
                                <th class="min-w-70px">Solusi</th>
                                <th class="min-w-70px">Dibuat Tanggal</th>
                                <th class="min-w-70px">Status</th>
                                {{-- <th class="min-w-70px">Keterangan</th> --}}
                                <th class="min-w-100px">Aksi</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-black-600 fw-bold">
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
                                        <!--begin::Customer Name=-->
                                        {{-- <td>
                                            {{ $ticket->customers->name }}
                                        </td> --}}
                                        <!--end::Customer Name=-->
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
                                        <!--end::Priority=-->
                                        <td>{!! Str::limit($ticket->description, 150) !!}</td>
                                        <td>{!! Str::limit($ticket->completion_notes, 150) !!}</td>
                                        <!--begin::Payment method=-->
                                        <td>
                                            {{ \Carbon\Carbon::parse($ticket->created_at)->locale('id')->translatedFormat('d F Y') }}
                                        </td>
                                        <!--end::Payment method=-->
                                        <!--begin::Date=-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($ticket->status_id == '1')
                                                    <span class="badge"
                                                        style="background-color:red ; color: white; font-weight:bold">Tertunda</span>
                                                @elseif($ticket->status_id == '2')
                                                    <span class="badge"
                                                        style="background-color:blue ; color: white; font-weight:bold">Diterima</span>
                                                @elseif($ticket->status_id == '3')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E ; color: white; font-weight:bold">Proses</span>
                                                @elseif($ticket->status_id == '4')
                                                    <span class="badge"
                                                        style="background-color:green ; color: white; font-weight:bold">Selesai</span>
                                                @elseif($ticket->status_id == '5')
                                                    <span class="badge"
                                                        style="background-color:rgb(185, 192, 2) ; color: white; font-weight:bold">Buka
                                                        Kembali</span>
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold">-</span>
                                                @endif

                                                @if (($ticket->status && $ticket->status_id == '2') || $ticket->status_id == '3' || $ticket->status_id == '5')
                                                    <form
                                                        action="{{ route('staffSubdit.tickets.statusTicket', $ticket->id) }}"
                                                        method="POST" id="statusForm_{{ $ticket->id }}">
                                                        @csrf
                                                        <input type="hidden" name="completion_notes"
                                                            id="completionNotesInput_{{ $ticket->id }}">
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

                                        {{-- <td>
                                            @if ($ticket->latestHistory)
                                                @php
                                                    $updatedByUser = $ticket->latestHistory->status_changedBy
                                                        ? App\Models\User::find($ticket->latestHistory->status_changedBy)
                                                        : null;
                                                @endphp

                                                {{ $updatedByUser ? $updatedByUser->name : '-' }}
                                            @else
                                                -
                                            @endif
                                            :
                                            {{ $ticket->latestHistory ? date('d F Y | H:i:s', strtotime($ticket->latestHistory->created_at)) : '-' }}
                                        </td> --}}


                                        <!--begin::Action=-->
                                        <td>
                                            @if (($ticket->status && $ticket->status_id == '2') || $ticket->status_id == '3' || $ticket->status_id == '5')
                                                @can('Edit Ticket')
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('staffSubdit.ticket.edit', $ticket->id) }}"
                                                        type="button" title="Ubah Tiket">
                                                        <span class="menu-icon" style="fill: #bd6710">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.47403C21.7817 5.85581 21.9962 6.37355 21.9962 6.91353C21.9962 7.4535 21.7817 7.97125 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.7737 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('Delete Ticket')
                                                    <a class="menu-link ms-3" href="#" type="reset"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_ticket_{{ $ticket->id }}"
                                                        title="Hapus Tiket">
                                                        <span class="menu-icon" style="fill: #e21414">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('Show Ticket')
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('staffSubdit.ticket.show', $ticket->id) }}"
                                                        type="button" title="Lihat Tiket">
                                                        <span class="menu-icon" style="fill: #1218ca">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C15.5 18 18 15.5 18 12.5C18 9.5 15.5 7 12.5 7C9.5 7 7 9.5 7 12.5C7 15.5 9.5 18 12.5 18Z" fill="currentColor" />
                                                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8ZM12.5 15.5C14.1569 15.5 15.5 14.1569 15.5 12.5C15.5 10.8431 14.1569 9.5 12.5 9.5C10.8431 9.5 9.5 10.8431 9.5 12.5C9.5 14.1569 10.8431 15.5 12.5 15.5Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('Send Ticket')
                                                    <a class="menu-link ms-3" href="" type="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_ticket2_{{ $ticket->id }}"
                                                        title="Pengajuan Tiket">
                                                        <span class="menu-icon" style="fill: #0d8987">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" version="1.1">
                                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                                    <path d="M17.4 11V13C17.4 13.6 17 14 16.4 14H15.4C14.8 14 14.4 13.6 14.4 13V11C14.4 10.4 14.8 10 15.4 10H16.4C17 10 17.4 10.4 17.4 11Z" fill="currentColor" />
                                                                    <path d="M12.4 11V13C12.4 13.6 12 14 11.4 14H10.4C9.8 14 9.4 13.6 9.4 13V11C9.4 10.4 9.8 10 10.4 10H11.4C12 10 12.4 10.4 12.4 11Z" fill="currentColor" />
                                                                    <path d="M7.4 11V13C7.4 13.6 7 14 6.4 14H5.4C4.8 14 4.4 13.6 4.4 13V11C4.4 10.4 4.8 10 5.4 10H6.4C7 10 7.4 10.4 7.4 11Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                @endcan
                                            @else
                                                @can('Show Ticket')
                                                    <a class="menu-link ms-3"
                                                        href="{{ route('staffSubdit.ticket.show', $ticket->id) }}"
                                                        type="button" title="Lihat Tiket">
                                                        <span class="menu-icon" style="fill: #1218ca">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C15.5 18 18 15.5 18 12.5C18 9.5 15.5 7 12.5 7C9.5 7 7 9.5 7 12.5C7 15.5 9.5 18 12.5 18Z" fill="currentColor" />
                                                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8ZM12.5 15.5C14.1569 15.5 15.5 14.1569 15.5 12.5C15.5 10.8431 14.1569 9.5 12.5 9.5C10.8431 9.5 9.5 10.8431 9.5 12.5C9.5 14.1569 10.8431 15.5 12.5 15.5Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
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
                        <form action="{{ route('staffSubdit.ticket.destroy', $ticket->id) }}" method="POST"
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
                            Form Pengalihan Tiket Ke SIAK Dev
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <form action="{{ route('staffSubdit.tickets.send', $ticket->id) }}" method="POST" class="d-inline">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5>Apakah Anda yakin tugas Tiket ini dialihkan kepada SIAK Dev?</h5>
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

                                    <select name="level4" hidden required>
                                        @foreach ($siakDevUsers as $roleId)
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

                        <div id="completionDetails_{{ $ticket->id }}" style="display: none;">
                            <label for="completionNotes_{{ $ticket->id }}" class="mt-4 mb-2">Keterangan
                                Penyelesaian:</label>
                            <textarea name="completion_notes" id="completionNotes_{{ $ticket->id }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmButton_{{ $ticket->id }}">Ya, Ubah
                            Status</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('resetButton').addEventListener('click', function() {
                const form = document.getElementById('filterForm');
                const selects = form.querySelectorAll('select');
                selects.forEach(select => {
                    $(select).val('all').trigger('change');
                });
            });

            document.getElementById('statusSelect_{{ $ticket->id }}').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let statusName = selectedOption.text;
                let statusForm = document.getElementById('statusForm_{{ $ticket->id }}');

                document.getElementById('status-name-{{ $ticket->id }}').textContent = statusName;

                // if (this.value == '4') {
                //     document.getElementById('completionDetails_{{ $ticket->id }}').style.display = 'block';
                // } else {
                //     document.getElementById('completionDetails_{{ $ticket->id }}').style.display = 'none';
                // }

                if (this.value == '4') {
                // Jika status "Selesai", langsung redirect tanpa modal
                window.location.href = "{{ route('staffSubdit.tickets.confirm', $ticket->id) }}";
                return;
            }

                $('#confirmModal_{{ $ticket->id }}').modal('show');

                document.getElementById('confirmButton_{{ $ticket->id }}').onclick = function() {
                    let completionNotes = document.getElementById('completionNotes_{{ $ticket->id }}').value.trim();

                    if (document.getElementById('statusSelect_{{ $ticket->id }}').value == 4 && !completionNotes) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Alasan selesainya wajib diisi!',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Konfirmasi Perubahan Status',
                        text: `Apakah Anda yakin ingin mengubah status tiket ini menjadi ${statusName}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ubah Status',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('completionNotesInput_{{ $ticket->id }}').value = completionNotes;
                            statusForm.submit();
                        }
                    });
                };
            });

            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll("textarea[id^='completionNotes_{{ $ticket->id }}']").forEach((textarea) => {
                    ClassicEditor.create(textarea, {
                        toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList'],
                    }).then(editor => {
                        editor.model.document.on('change:data', () => {
                            textarea.value = editor.getData();
                        });
                    }).catch(error => {
                        console.error(error);
                    });
                });
            });
        </script>
    @endforeach
@endsection
