@extends('layouts.dashboard.app')

@section('title')
    Tambah Tiket | SIAK Dukcapil
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
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Tambah Tiket</small>
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
                            <form class="row g-3 needs-validation" method="POST" action="{{ route('ticket.store') }}"
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
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Pemilik</label>
                                    <select name="customer" class="form-control @error('customer') is-invalid @enderror"
                                        required autofocus>
                                        <option value="" selected disabled>Pilih Pemilik</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
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

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Ditugaskan Ke</label>
                                    <select name="assign_to" class="form-control @error('assign_to') is-invalid @enderror"
                                        required autofocus>
                                        <option value="" selected disabled>Pilih Departemen</option>
                                        @foreach ($assignTo as $assign)
                                            <option value="{{ $assign->id }}">{{ $assign->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('assign_to')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Prioritas</label>
                                    <select name="priority_id"
                                        class="form-control @error('priority_id') is-invalid @enderror" required autofocus>
                                        <option value="" selected disabled>Pilih Prioritas</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}">{{ $priority->priority_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('priority_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Tanggal Jatuh Tempo</label>
                                    <input type="date" name="due_date"
                                        class="form-control @error('due_date') is-invalid @enderror" required autofocus>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('due_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Status</label>
                                    <select name="status_id" class="form-control @error('status_id') is-invalid @enderror"
                                        required autofocus>
                                        <option value="" selected disabled>Pilih Status</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('status_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Kategori</label>
                                    <select name="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror" required autofocus>
                                        <option value="" selected disabled>Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="10" rows="3"></textarea>

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
                                    <label class="d-block fw-bold fs-6 mb-5">Lampiran</label>
                                    <div class="custom-dropzone" onclick="document.getElementById('attachments').click()">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="dz-message">
                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini atau klik untuk mengunggah.</h3>
                                            <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
                                        </div>
                                        <div class="preview"></div>
                                    </div>
                                    <input type="file" id="attachments" name="attachments[]" class="form-control d-none" multiple>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('attachments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="error-message" id="error-message"></div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route('ticket.index') }}" class="btn btn-danger">Cancel</a>
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

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
