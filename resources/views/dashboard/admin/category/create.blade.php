@extends('layouts.dashboard.app')

@section('title')
    Tambah Kategori | PLN Icon+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <a href="{{ route('category.index') }}" class="btn btn-custom">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Tambah Kategori</h4>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <form class="row g-3 needs-validation" method="POST" action="{{ route('category.store') }}"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="validationCustom01" class="form-label">Nama Kategori</label>
                                        <input type="text"
                                            class="form-control @error('category_name') is-invalid @enderror"
                                            id="category_name" name="category_name" autofocus required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('category_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="validationCustom01" class="form-label">Warna Label</label>
                                        <select type="text" class="form-control @error('layanan_id') is-invalid @enderror"
                                            id="layanan_id" name="layanan_id" autofocus >
                                            @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('color')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a href="{{ route('category.index') }}" class="btn btn-danger">Cancel</a>
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
@endsection
