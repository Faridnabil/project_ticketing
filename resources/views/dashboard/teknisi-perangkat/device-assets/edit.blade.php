@extends('layouts.dashboard.app')

@section('title')
    Edit Aset Perangkat | Ticketing
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Edit Aset Perangkat
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Perbarui Data Aset Perangkat</small>
                </h1>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="row g-5 g-xl-12">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8">
                        <div class="card-body pt-5">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('teknisiHardware.deviceAssets.update', $deviceAsset->id) }}"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="col-md-12">
                                    <label for="device_name" class="form-label">Nama Perangkat</label>
                                    <input type="text" class="form-control @error('device_name') is-invalid @enderror"
                                        id="device_name" name="device_name"
                                        value="{{ old('device_name', $deviceAsset->device_name) }}" required>

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
                                    <label for="description" class="form-label">Keterangan</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="10" rows="3">{{ old('description', $deviceAsset->description) }}</textarea>
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
                                    <label for="photo_location" class="form-label">Foto Lokasi Perangkat</label>
                                    <input type="file" class="form-control @error('photo_location') is-invalid @enderror"
                                        name="photo_location" accept=".jpg, .jpeg, .png">
                                    <p>File harus berupa <b>jpg, jpeg, atau png</b></p>
                                    @error('photo_location')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="photo_device" class="form-label">Foto Perangkat</label>
                                    <input type="file" class="form-control @error('photo_device') is-invalid @enderror"
                                        name="photo_device" accept=".jpg, .jpeg, .png">
                                    <p>File harus berupa <b>jpg, jpeg, atau png</b></p>
                                    @error('photo_device')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                    <a href="{{ route('teknisiHardware.deviceAssets.index') }}"
                                        class="btn btn-danger">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
@endsection
