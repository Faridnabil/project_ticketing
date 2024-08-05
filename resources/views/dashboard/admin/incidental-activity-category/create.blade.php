@extends('layouts.dashboard.app')

@section('title')
    Tambah Kategori Incidental Activity | PLN Icon+
@endsection

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tambah Kategori Incidental Activity
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Kategori</small>
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
                            <form class="row g-3 needs-validation" method="POST" action="{{ route('incidental-activity-category.store') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" autofocus required>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('category_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Warna Label</label>
                                    <input type="color" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="#ff0000" autofocus required>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route('incidental-activity-category.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
