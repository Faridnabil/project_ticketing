@extends('layouts.dashboard.app')

@section('title')
    Tambah Aset Perangkat | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Aset Perangkat
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Aset Perangkat</small>
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
                                action="{{ route('teknisiHardware.deviceAssets.store') }}" enctype="multipart/form-data"
                                novalidate>
                                @csrf
                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Nama Perangkat</label>
                                    <input type="text" class="form-control @error('device_name') is-invalid @enderror"
                                        id="device_name" name="device_name" autofocus required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('device_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Keterangan</label>
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
                                    <label for="validationCustom01" class="form-label">Foto Lokasi Perangkat</label>
                                    <input type="file" class="form-control" name="photo_location"
                                        accept=".jpg, .jpeg, .png">
                                    <p>File harus berupa
                                        <b>jpg, jpeg, atau png</b>
                                    </p>
                                </div>

                                <script>
                                    document.querySelector('input[name="photo_location"]').addEventListener('change', function(event) {
                                        const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
                                        const file = event.target.files[0];
                                        if (file) {
                                            const extension = file.name.split('.').pop().toLowerCase();
                                            if (!allowedExtensions.includes(extension)) {
                                                alert(
                                                    'Tipe File Tidak Diizinkan. Tolong upload file dengan tipe: jpg, jpeg, png'
                                                );
                                                event.target.value = ''; // Clear the input
                                            }
                                        }
                                    });
                                </script>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Foto Perangkat</label>
                                    <input type="file" class="form-control" name="photo_device"
                                        accept=".jpg, .jpeg, .png">
                                    <p>File harus berupa
                                        <b>jpg, jpeg, atau png</b>
                                    </p>
                                </div>

                                <script>
                                    document.querySelector('input[name="photo_device"]').addEventListener('change', function(event) {
                                        const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
                                        const file = event.target.files[0];
                                        if (file) {
                                            const extension = file.name.split('.').pop().toLowerCase();
                                            if (!allowedExtensions.includes(extension)) {
                                                alert(
                                                    'Tipe File Tidak Diizinkan. Tolong upload file dengan tipe: jpg, jpeg, png'
                                                );
                                                event.target.value = ''; // Clear the input
                                            }
                                        }
                                    });
                                </script>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route('teknisiHardware.deviceAssets.index') }}"
                                        class="btn btn-danger">Cancel</a>
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
@endsection
