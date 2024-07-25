@extends('layouts.dashboard.app')

@section('title')
    Ubah Provinsi | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Provinsi
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Provinsi</small>
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
                                action="{{ route('province.update', $province->id) }}" enctype="multipart/form-data"
                                novalidate>
                                @method('PUT')
                                @csrf
                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Kode Provinsi</label>
                                    <input type="text" class="form-control @error('no_province') is-invalid @enderror"
                                        id="no_province" name="no_province"
                                        value="{{ old('no_province', $province->no_province) }}" autofocus required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('no_province')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Nama Provinsi</label>
                                    <input type="text" class="form-control @error('province_name') is-invalid @enderror"
                                        id="province_name" name="province_name"
                                        value="{{ old('province_name', $province->province_name) }}" autofocus required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('province_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route('province.index') }}" class="btn btn-danger">Cancel</a>
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
