@extends('layouts.dashboard.app')

@section('title')
    Tambah Peran | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Peran
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Tambah Peran</small>
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
                            <!--begin::Error-->
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> Ada beberapa masalah dengan masukan Anda.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!--end::Error-->
                            <form class="row g-3 needs-validation" method="POST" action="{{ route('role.store') }}"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Peran</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror mb-4"
                                        id="name" name="name" value="{{ old('name') }}" autofocus required>

                                    <div class="valid-feedback">
                                        Terlihat Baik!
                                    </div>

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!--begin::Input group Permission-->

                                <div class="col-md-9">
                                    <div class="role-permissions">
                                        <div class="row">
                                            @foreach ($permission as $item)
                                                <!-- Assuming you want 3 permissions per row -->
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input mb-3" type="checkbox" name="permission[]"
                                                            id="inlineCheckbox{{ $item->id }}"
                                                            value="{{ $item->id }}">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox{{ $item->id }}">{{ $item->name }}</label>
                                                    </div>
                                                </div>
                                                @if ($loop->index % 3 == 2)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!--end::Input group Permission-->

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route('role.index') }}" class="btn btn-danger">Batal</a>
                                </div>
                            </form><!--end form-->
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
