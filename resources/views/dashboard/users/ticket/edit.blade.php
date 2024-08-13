@extends('layouts.dashboard.app')

@section('title')
    Edit Tiket | PLN ICON+
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket Saya
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Edit Tiket</small>
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
        <div id="kt_content_container" class="container">
            <!--begin::Row-->
            <div class="row g-5 g-xl-12">
                <div class="col-xl-12">
                    <!--begin::List Widget 1-->
                    <div class="card card-xl-stretch mb-xl-8">
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
                                        id="title" name="title" value="{{ old('title', $ticket->title) }}" autofocus
                                        required>

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
                                    <select name="status_id" class="form-control @error('status_id') is-invalid @enderror"
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
                                    <div class="custom-dropzone" onclick="document.getElementById('attachments').click()">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="dz-message">
                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini atau
                                                klik untuk mengunggah.</h3>
                                            <span class="fs-7 fw-bold text-gray-400">Unggah hingga 10 file</span>
                                        </div>
                                        <div class="preview" id="preview"></div>
                                    </div>
                                    <input type="file" id="attachments" name="attachments[]" class="form-control d-none"
                                        multiple>

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
                    <!--end::List Widget 1-->
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
