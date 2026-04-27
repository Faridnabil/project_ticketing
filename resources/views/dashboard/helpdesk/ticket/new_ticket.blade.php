@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
@endsection

@section('content')
    <style>
        .btn-custom {
            margin-right: 12px;
            border: 1px solid #e4e6ef;
            background-color: #ffffff;
            color: #7e8299;
            padding: 12px 25px;
            border-radius: 8px;
            display: inline-block;
            transition: all 0.2s ease-in-out;
            text-decoration: none !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
            cursor: pointer;
            border-bottom: 3px solid #e4e6ef;
        }

        .btn-custom:hover {
            background-color: #f8f9fa;
            color: #009ef7;
            border-bottom-color: #009ef7;
            transform: translateY(-1px);
        }

        .btn-custom.active {
            background-color: #009ef7;
            color: white !important;
            border-color: #009ef7;
            border-bottom: 3px solid #006eb3;
            box-shadow: 0 4px 10px rgba(0, 158, 247, 0.3);
        }

        .font-regular {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .custom-dropzone {
            border: 2px dashed #009ef7;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #f1faff;
        }
    </style>

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
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Tiket Baru</small>
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

            <div class="Header" style="margin-bottom: 25px; padding-left: 5px;">
                <ul class="nav custom-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="btn-custom font-regular {{ !$hasFilter ? 'active' : '' }}" data-bs-toggle="tab"
                            href="#tab_buat_tiket">
                            Buat Tiket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-custom font-regular {{ $hasFilter ? 'active' : '' }}" data-bs-toggle="tab"
                            href="#tab_data_tiket">
                            Data Tiket
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <!-- Tab Buat Tiket -->
                <div class="tab-pane fade {{ !$hasFilter ? 'show active' : '' }}" id="tab_buat_tiket" role="tabpanel">
                    <div class="card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h2 class="fw-bolder">Tambah Tiket Baru</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('helpdesk.ticket.store') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="no_ticket" value="{{ old('no_ticket') }}">
                                <input type="hidden" name="created_by" value="{{ auth()->user()->name }}">
                                <select name="level1" hidden required>
                                    @foreach ($helpdeskRoles as $roleId)
                                        <option value="{{ $roleId }}" {{ old('level1') == $roleId ? 'selected' : '' }}>
                                            {{ $roleId }}</option>
                                    @endforeach
                                </select>

                                <div class="col-md-6">
                                    <label for="category_id_create" class="form-label">Kategori Permasalahan</label>
                                    <select name="category_id" id="category_id_create"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Kategori" required>
                                        <option></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->code ? $category->code . ' - ' : '' }}{{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="province_id_create" class="form-label">Nama Propinsi</label>
                                    <select id="province_id_create" data-control="select2" name="province_id"
                                        class="form-select @error('province_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>Pilih Propinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                {{ $province->no_province }} - {{ $province->province_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="city_or_regency_id_create" class="form-label">Nama Kabupaten/Kota</label>
                                    <select id="city_or_regency_id_create" data-control="select2" name="city_or_regency_id"
                                        class="form-select @error('city_or_regency_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                                    </select>
                                    @error('city_or_regency_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status_id_create" class="form-label">Status</label>
                                    <select name="status_id" id="status_id_create"
                                        class="form-select @error('status_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Status" required>
                                        <option></option>
                                        @foreach ($statuses as $status)
                                            @if ($status->status_name !== 'Buka Kembali')
                                                <option value="{{ $status->id }}"
                                                    {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->status_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="pic" class="form-label">PIC</label>
                                    <input type="text" name="pic" value="{{ old('pic') }}"
                                        class="form-control @error('pic') is-invalid @enderror" id="pic"
                                        placeholder="Masukan PIC">
                                    @error('pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                                        class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                                        placeholder="Masukan jabatan">
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="priority_id_create" class="form-label">Prioritas</label>
                                    <select name="priority_id" id="priority_id_create"
                                        class="form-select @error('priority_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Prioritas" required>
                                        <option></option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                                {{ $priority->priority_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('priority_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label">No Hp / WA</label>
                                    <input type="number" name="no_hp" value="{{ old('no_hp') }}"
                                        class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                        placeholder="Masukan Nomor Handphone/WA">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="10" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="d-block fw-bold fs-6 mb-5">Lampiran</label>
                                    <div class="custom-dropzone"
                                        onclick="document.getElementById('attachments_create').click()">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="dz-message">
                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini atau
                                                klik untuk mengunggah.</h3>
                                            <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
                                        </div>
                                        <div class="preview" id="preview_create"></div>
                                    </div>
                                    <input type="file" id="attachments_create" name="attachments[]"
                                        class="form-control d-none" multiple>
                                    @error('attachments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mt-8">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <button type="button" class="btn btn-danger" onclick="location.reload()">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab Data Tiket -->
                <div class="tab-pane fade {{ $hasFilter ? 'show active' : '' }}" id="tab_data_tiket" role="tabpanel">
                    <div class="card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title w-100">
                                <form id="filterForm" method="GET" action="{{ route('helpdesk.newTickets.index') }}"
                                    class="row g-3 w-100">
                                    <div class="col-md-2">
                                        <input type="date" name="tanggal_mulai" class="form-control"
                                            style="border: 2px solid #28a745;"
                                            value="{{ request('tanggal_mulai') }}" placeholder="Tanggal Mulai">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="tanggal_selesai" class="form-control"
                                            style="border: 2px solid #dc3545;"
                                            value="{{ request('tanggal_selesai') }}" placeholder="Tanggal Selesai">
                                    </div>

                                    <div class="col-md-2">
                                        <select name="level" class="form-select" data-control="select2"
                                            data-placeholder="Pilih Disposisi">
                                            <option value="all">Semua Disposisi</option>
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}"
                                                    {{ request('level') == $level->id ? 'selected' : '' }}>
                                                    {{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="category_id" class="form-select" data-control="select2"
                                            data-placeholder="Pilih Kategori">
                                            <option value="all">Semua Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="priority_id" class="form-select" data-control="select2"
                                            data-placeholder="Pilih Prioritas">
                                            <option value="all">Semua Prioritas</option>
                                            @foreach ($priorities as $priority)
                                                <option value="{{ $priority->id }}"
                                                    {{ request('priority_id') == $priority->id ? 'selected' : '' }}>
                                                    {{ $priority->priority_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="status_id" class="form-select" data-control="select2"
                                            data-placeholder="Pilih Status">
                                            <option value="all">Semua Status</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->status_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select id="province_id_filter" name="province_id" class="form-select"
                                            data-control="select2">
                                            <option value="all">Semua Provinsi</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}"
                                                    {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                                    {{ $province->no_province }} - {{ $province->province_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select id="city_or_regency_id_filter" name="city_or_regency_id"
                                            class="form-select" data-control="select2">
                                            <option value="all">Semua Kabupaten/Kota</option>
                                            @foreach ($city_or_regencies as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ request('city_or_regency_id') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->no_city_or_regency }} - {{ $city->city_or_regency_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-1">Tampilkan</button>
                                        <button type="button" id="reset_filter" class="btn btn-danger">Atur ulang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                <!--end::Card header-->
                <div class="card-body pt-0">
                    @if (!$hasFilter)
                        <div class="text-center py-10">
                            <img src="{{ asset('assets/media/illustrations/sigma-1/5.png') }}" class="h-150px"
                                alt="">
                            <h3 class="fw-bolder mt-5">Pilih filter untuk menampilkan data</h3>
                            <p class="text-gray-400">Gunakan form di atas untuk mencari data tiket.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="kt_datatable_example_1" class="table table-row-bordered gy-5">
                                <thead>
                                    <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-70px">No</th>
                                        <th class="min-w-70px">Nomor Tiket</th>
                                        <th class="min-w-70px">Kategori</th>
                                        <th class="min-w-70px">Disposisi</th>
                                        <th class="min-w-70px">Prioritas</th>
                                        <th class="min-w-70px">Dibuat Tanggal</th>
                                        <th class="min-w-70px">Status</th>
                                        <th class="min-w-100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-black-600 fw-bold">
                                    @forelse ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ticket->no_ticket }}</td>
                                            <td>{{ $ticket->category->category_name }}</td>
                                            <td>
                                                @if ($ticket->level1 != null)
                                                    {{ $ticket->helpdesk->name ?? '-' }}
                                                @elseif ($ticket->level2 != null)
                                                    {{ $ticket->koordinator->name ?? '-' }}
                                                @elseif ($ticket->level3 != null)
                                                    {{ $ticket->staffSubdit->name ?? '-' }}
                                                @elseif ($ticket->level4 != null)
                                                    {{ $ticket->siakDev->name ?? '-' }}
                                                @elseif ($ticket->level5 != null)
                                                    {{ $ticket->pejabat->name ?? '-' }}
                                                @else
                                                    <span class="badge"
                                                        style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $priorityColors = [
                                                        '4' => 'red',
                                                        '3' => '#FF7F3E',
                                                        '2' => 'blue',
                                                        '1' => 'green',
                                                    ];
                                                    $color = $priorityColors[$ticket->priority_id] ?? 'rgb(77, 75, 75)';
                                                @endphp
                                                <span class="badge"
                                                    style="background-color:{{ $color }}; color: white; font-weight:bold">
                                                    {{ $ticket->priority->priority_name ?? '-' }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($ticket->created_at)->locale('id')->translatedFormat('d F Y') }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $statusMap = [
                                                            '1' => ['Tertunda', 'red'],
                                                            '2' => ['Diterima', 'blue'],
                                                            '3' => ['Proses', '#FF7F3E'],
                                                            '4' => ['Selesai', 'green'],
                                                            '5' => ['Buka Kembali', 'rgb(185, 192, 2)'],
                                                        ];
                                                        $statusInfo = $statusMap[$ticket->status_id] ?? [
                                                            '-',
                                                            'rgb(77, 75, 75)',
                                                        ];
                                                    @endphp
                                                    <span class="badge"
                                                        style="background-color:{{ $statusInfo[1] }}; color: white; font-weight:bold">
                                                        {{ $statusInfo[0] }}
                                                    </span>

                                                    @if (in_array($ticket->status_id, ['2', '3', '5']))
                                                        <form
                                                            action="{{ route('helpdesk.tickets.statusTicket', $ticket->id) }}"
                                                            method="POST" id="statusForm_{{ $ticket->id }}">
                                                            @csrf
                                                            <input type="hidden" name="completion_notes"
                                                                id="completionNotesInput_{{ $ticket->id }}">
                                                            <div class="custom-select-wrapper ms-2">
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
                                            <td>
                                                <div class="d-flex">
                                                    @can('Edit Ticket')
                                                        <a class="menu-link ms-3"
                                                            href="{{ route('helpdesk.ticket.edit', $ticket->id) }}"
                                                            type="button">
                                                            <span class="menu-icon" style="fill: #bd6710" title="Ubah Tiket">
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
                                                            href="{{ route('helpdesk.ticket.show', $ticket->id) }}"
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
                                                    @if ($ticket->level1 == 2)
                                                        @can('Send Ticket')
                                                            <a class="menu-link ms-3" href="" type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_ticket2_{{ $ticket->id }}"
                                                                title="Pengajuan Tiket">
                                                                <span class="menu-icon" style="fill: #0d8987">
                                                                    <span class="svg-icon svg-icon-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="512"
                                                                            height="512" viewBox="0 0 24 24" version="1.1">
                                                                            <path
                                                                                d="M23.017,8.785c-.595-.542-1.364-.816-2.168-.782-.804,.038-1.544,.387-2.086,.981l-3.216,3.534c-.551-.909-1.55-1.519-2.689-1.519H3c-1.654,0-3,1.346-3,3v7c0,1.654,1.346,3,3,3H13.448l9.788-10.985c1.093-1.227,.994-3.124-.219-4.229Zm-1.274,2.899l-9.191,10.315H3c-.551,0-1-.448-1-1v-7c0-.552,.449-1,1-1H12.858c.63,0,1.142,.513,1.142,1.143,0,.564-.421,1.051-.981,1.13l-5.161,.737,.283,1.98,5.16-.737c1.175-.168,2.13-.987,2.515-2.059l4.426-4.864c.182-.199,.43-.316,.7-.329,.274-.016,.528,.081,.728,.263,.407,.371,.44,1.009,.073,1.421ZM15,2.5c0-1.379-1.122-2.5-2.5-2.5H5.5c-1.378,0-2.5,1.121-2.5,2.5v6.5H15V2.5Zm-2,4.5H5V2.5c0-.275,.224-.5,.5-.5h7c.276,0,.5,.225,.5,.5V7ZM7,3h4v2H7V3Z" />
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($tickets as $ticket)
    {{-- Hapus Modal --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_ticket_{{ $ticket->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title m-0 text-white">Form Hapus Tiket</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Apakah Anda yakin menghapus Tiket ini?</h5>
                    <ul class="mt-3">
                        <li>{{ $ticket->no_ticket }}</li>
                        <li>{{ $ticket->title }}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <form action="{{ route('helpdesk.ticket.destroy', $ticket->id) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Send Modal --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_ticket2_{{ $ticket->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0 text-white">Form Pengalihan Tiket Ke Koordinator</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('helpdesk.tickets.send', $ticket->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <h5>Apakah Anda yakin tugas Tiket ini dialihkan kepada Koordinator?</h5>
                        <div class="p-5 bg-light rounded mt-5">
                            <h3>{{ $ticket->no_ticket }}</h3>
                            <p><strong>Kategori:</strong> {{ $ticket->category->category_name }}</p>
                            <p><strong>Status:</strong> {{ $ticket->status->status_name ?? '-' }}</p>
                            <p><strong>Nama Provinsi:</strong> {{ $ticket->province->province_name }}</p>
                            <p><strong>Nama Kota:</strong> {{ $ticket->cityOrRegency->city_or_regency_name }}</p>
                        </div>
                        <input type="hidden" name="level1" value="">
                        <select name="level2" hidden required>
                            @foreach ($koordinatorUsers as $roleId)
                                <option value="{{ $roleId }}">{{ $roleId }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Kirim Tiket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Confirm Modal for Status change --}}
    <div class="modal fade" id="confirmModal_{{ $ticket->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Perubahan Status</h5>
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

            if (this.value == '4') {
                window.location.href = "{{ route('helpdesk.tickets.confirm', $ticket->id) }}";
                return;
            }

            document.getElementById('status-name-{{ $ticket->id }}').textContent = statusName;
            $('#confirmModal_{{ $ticket->id }}').modal('show');

            document.getElementById('confirmButton_{{ $ticket->id }}').onclick = function() {
                Swal.fire({
                    title: 'Konfirmasi Perubahan Status',
                    text: `Apakah Anda yakin ingin mengubah status tiket ini menjadi ${statusName}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ubah Status',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        statusForm.submit();
                    }
                });
            };
        });
    </script>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reset logic
        $('#reset_filter').click(function() {
            $('#filterForm').find('input[type=date]').val('');
            $('#filterForm').find('select').val('all').trigger('change');
        });

        // Province-City Logic for Filter
        function loadCitiesFilter(provinceId, selectedCityId = null) {
            const citySelect = $('#city_or_regency_id_filter');
            if (provinceId && provinceId !== 'all') {
                citySelect.prop('disabled', true).html('<option value="all">Loading...</option>');
                fetch(`/get-cities/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.prop('disabled', false).html('<option value="all">Semua Kabupaten/Kota</option>');
                        data.forEach(city => {
                            citySelect.append(`<option value="${city.id}" ${city.id == selectedCityId ? 'selected' : ''}>${city.no_city_or_regency} - ${city.city_or_regency_name}</option>`);
                        });
                        citySelect.trigger('change');
                    });
            } else {
                citySelect.html('<option value="all">Semua Kabupaten/Kota</option>').trigger('change');
            }
        }

        $('#province_id_filter').on('change', function() {
            loadCitiesFilter($(this).val());
        });

        // Province-City Logic for Create Form
        function loadCitiesCreate(provinceId, selectedCityId = null) {
            const citySelect = $('#city_or_regency_id_create');
            if (provinceId) {
                fetch(`/get-cities/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.html('<option value="" selected disabled>Pilih Kabupaten/Kota</option>');
                        data.forEach(city => {
                            citySelect.append(`<option value="${city.id}" ${city.id == selectedCityId ? 'selected' : ''}>${city.no_city_or_regency} - ${city.city_or_regency_name}</option>`);
                        });
                        citySelect.trigger('change');
                    });
            } else {
                citySelect.html('<option value="" selected disabled>Pilih Kabupaten/Kota</option>').trigger('change');
            }
        }

        $('#province_id_create').on('change', function() {
            loadCitiesCreate($(this).val());
        });

        // CKEditor for description
        if (document.querySelector('#description')) {
            ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
        }

        // Restore city selection if province was selected on filter
        const initialProvinceFilter = $('#province_id_filter').val();
        if (initialProvinceFilter && initialProvinceFilter !== 'all') {
            loadCitiesFilter(initialProvinceFilter, "{{ request('city_or_regency_id') }}");
        }
    });
</script>
@endsection
