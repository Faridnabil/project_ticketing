@extends('layouts.dashboard.app')

@section('title')
    Tambah Tiket | PLN Icon+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Tambah Tiket</h4>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <form class="row g-3 needs-validation" method="POST" action="{{ route('myTicket.store') }}"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <input type="hidden" name="no_ticket">
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Judul</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" autofocus required>

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
                                        <select name="t_users" class="form-control @error('t_users') is-invalid @enderror"
                                            required autofocus style="pointer-events: none;">
                                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                        </select>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('t_users')
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
                                            <option disabled selected>Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}
                                                </option>
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
                                        <label for="validationCustom02" class="form-label">Deskripsi</label>
                                        <textarea id="description" name="description" autofocus required></textarea>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="d-block fw-bold mb-2">Lampiran</label>
                                        <div class="custom-dropzone"
                                            onclick="document.getElementById('attachments').click()">
                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                            <div class="dz-message">
                                                <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini
                                                    atau
                                                    klik untuk mengunggah.</h3>
                                                <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
                                            </div>
                                            <div class="preview"></div>
                                        </div>
                                        <input type="file" id="attachments" name="attachments[]"
                                            class="form-control d-none" multiple>
                                        <div class="valid-feedback">Looks good!</div>
                                        @error('attachments')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="error-message" id="error-message"></div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Ajukan</button>
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
