@extends('layouts.dashboard.app')

@section('title')
    Edit Tiket | PLN ICON+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Tiket</h4>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('myTicket.update', $ticket->id) }}" enctype="multipart/form-data"
                                    novalidate>
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="no_ticket" value="{{ $ticket->no_ticket }}">
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Judul</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $ticket->title) }}"
                                            autofocus required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Pemilik</label>
                                        <select name="customer" class="form-control @error('customer') is-invalid @enderror"
                                            required autofocus style="pointer-events: none;">
                                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                        </select>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('customer')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Kategori</label>
                                        <select name="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Pilih Kategori" required autofocus>
                                            <option disabled>Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="status_id" value="1">

                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Deskripsi</label>
                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                            cols="10" rows="3">{{ old('description', $ticket->description) }}</textarea>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validationCustom01" class="form-label">Status</label>
                                        <select name="status_id"
                                            class="form-control @error('status_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Pilih Kategori" required autofocus>
                                            <option disabled>Pilih Status</option>
                                            @foreach ($statuses as $status)
                                                @if (in_array($status->status_name, ['Proses', 'Selesai']))
                                                    <option value="{{ $status->id }}"
                                                        {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->status_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">Looks good!</div>
                                        @error('status_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block fw-bold fs-6 mb-2">Lampiran</label>
                                        <div class="custom-dropzone"
                                            onclick="document.getElementById('attachments').click()">
                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                            <div class="dz-message">
                                                <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini
                                                    atau
                                                    klik untuk mengunggah.</h3>
                                                <span class="fs-7 fw-bold text-gray-400">Unggah hingga 10 file</span>
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
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                        <a href="{{ route('myTicket.index') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </form>
                                <!--end form-->
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->

    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
