@extends('layouts.dashboard.app')

@php
    $user = auth()->user();
@endphp

@section('title')
    Edit Tiket | SIAK Dukcapil
@endsection

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Edit Tiket</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="row g-5 g-xl-12">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8">
                        <div class="card-body pt-5">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('helpdesk.ticket.update', $ticket->id) }}" enctype="multipart/form-data"
                                novalidate>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="no_ticket" value="{{ $ticket->no_ticket }}">

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Kategori Permasalahan</label>
                                    <select name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Kategori" required autofocus>
                                        <option></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="regional_name" class="form-label">Nama Wilayah</label>
                                    <input type="text" class="form-control" id="regional_name" value="{{ $user->regional->code }} - {{ $user->regional->regional_name }}" readonly>
                                    <input type="hidden" name="regional_id" value="{{ $user->regional_id }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="provinsi_name" class="form-label">Nama Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi_name" value="{{ $user->provinsi->code }} - {{ $user->provinsi->name }}" readonly>
                                    <input type="hidden" name="provinsi_id" value="{{ $user->provinsi_id }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="kabupaten_name" class="form-label">Nama Kabupaten/Kota</label>
                                    <input type="text" class="form-control" id="kabupaten_name" value="{{ $user->kabupaten->code }} - {{ $user->kabupaten->type }} {{ $user->kabupaten->name }}" readonly>
                                    <input type="hidden" name="kabupaten_id" value="{{ $user->kabupaten_id }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Status</label>
                                    <select name="status_id" class="form-select @error('status_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Status" required autofocus>
                                        <option></option>
                                        @foreach ($statuses as $status)
                                            @if ($ticket->status_id == $selesaiStatusId)
                                                @if ($status->id != $tertundaStatusId && $status->id != $diterimaStatusId)
                                                    <option value="{{ $status->id }}"
                                                        {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->status_name }}
                                                    </option>
                                                @endif
                                            @else
                                                @if ($status->id != $bukaKembaliStatusId)
                                                    <option value="{{ $status->id }}"
                                                        {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->status_name }}
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('status_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">PIC</label>
                                    <input type="text" name="pic"
                                        class="form-control @error('pic') is-invalid @enderror" id="pic"
                                        placeholder="Masukan PIC" value="{{ old('pic', $ticket->pic) }}">

                                    <div class="valid-feedback">Looks good!</div>
                                    @error('pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Prioritas</label>
                                    <select name="priority_id"
                                        class="form-select @error('priority_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Prioritas" required autofocus>
                                        <option></option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ $ticket->priority_id == $priority->id ? 'selected' : '' }}>
                                                {{ $priority->priority_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('priority_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">No Hp / WA</label>
                                    <input type="number" name="no_hp"
                                        class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                        placeholder="Masukan Nomor Handphone/WA"
                                        value="{{ old('no_hp', $ticket->no_hp) }}">

                                    <div class="valid-feedback">Looks good!</div>
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="10" rows="3">{{ old('description', $ticket->description) }}</textarea>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block fw-bold fs-6 mb-5">Lampiran</label>
                                    <div class="custom-dropzone" onclick="document.getElementById('attachments').click()">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="dz-message">
                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini atau
                                                klik untuk mengunggah.</h3>
                                            <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
                                        </div>
                                        <div class="preview" id="preview"></div>
                                    </div>
                                    <input type="file" id="attachments" name="attachments[]"
                                        class="form-control d-none" multiple>
                                    <input type="hidden" id="removed_attachments" name="removed_attachments">
                                    <input type="hidden" id="remaining_attachments" name="remaining_attachments">
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('attachments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="error-message" id="error-message"></div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Ubah</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const regionalSelect = $('#regional_id');
            const provinsiSelect = $('#provinsi_id');
            const kabupatenSelect = $('#kabupaten_id');

            // Ketika regional dipilih, load provinsi
            regionalSelect.on('change', function () {
                const regionalId = $(this).val();
                provinsiSelect.html('<option value="">Memuat Provinsi...</option>');
                kabupatenSelect.html('<option value="">Pilih Kabupaten/Kota</option>'); // kosongkan kabupaten

                if (regionalId) {
                    fetch(`/helpdesk/get-provinsi/${regionalId}`)
                        .then(response => response.json())
                        .then(data => {
                            provinsiSelect.html('<option value="">Pilih Provinsi</option>');
                            data.forEach(provinsi => {
                                provinsiSelect.append(`<option value="${provinsi.id}">${provinsi.code} - ${provinsi.name}</option>`);
                            });
                        })
                        .catch(error => {
                            console.error('Gagal memuat provinsi:', error);
                            provinsiSelect.html('<option value="">Gagal memuat data</option>');
                        });
                }
            });

            // Ketika provinsi dipilih, load kabupaten
            provinsiSelect.on('change', function () {
                const provinsiId = $(this).val();
                kabupatenSelect.html('<option value="">Memuat Kabupaten/Kota...</option>');

                if (provinsiId) {
                    fetch(`/helpdesk/get-kabupaten/${provinsiId}`)
                        .then(response => response.json())
                        .then(data => {
                            kabupatenSelect.html('<option value="">Pilih Kabupaten/Kota</option>');
                            data.forEach(kabupaten => {
                                kabupatenSelect.append(`<option value="${kabupaten.id}">${kabupaten.code} - ${kabupaten.name}</option>`);
                            });
                        })
                        .catch(error => {
                            console.error('Gagal memuat kabupaten:', error);
                            kabupatenSelect.html('<option value="">Gagal memuat data</option>');
                        });
                }
            });
        });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
    @endpush
@endsection
