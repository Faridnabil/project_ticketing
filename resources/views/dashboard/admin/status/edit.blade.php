@extends('layouts.dashboard.app')

@section('title')
    Ubah Status | PLN Icon+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Status</h4>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('status.update', $status->id) }}" enctype="multipart/form-data"
                                    novalidate>
                                    @method('PUT')
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="validationCustom01" class="form-label">Nama Status</label>
                                        <input type="text"
                                            class="form-control @error('status_name') is-invalid @enderror" id="status_name"
                                            name="status_name" value="{{ old('status_name', $status->status_name) }}"
                                            autofocus required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('status_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="validationCustom01" class="form-label">Warna Label</label>
                                        <input type="color" class="form-control @error('color') is-invalid @enderror"
                                            id="color" name="color" value="{{ $status->color }}" autofocus required>

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
                                        <a href="{{ route('status.index') }}" class="btn btn-danger">Cancel</a>
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
