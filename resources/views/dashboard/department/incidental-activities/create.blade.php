@extends('layouts.dashboard.app')

@section('title')
    Tambah Incidental Activity | PLN Icon+
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Incidental Activities
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Tambah Incidental Activity</small>
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
                            <form class="row g-3 needs-validation" method="POST" action="{{ route('department.incidental-activities.store') }}"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Judul</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
                                        required autofocus>
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
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="10" rows="3" required></textarea>
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
                                    <label for="category" class="form-label">Kategori</label>
                                    <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                                        id="category" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('category')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="start_time" class="form-label">Waktu Mulai</label>
                                    <input type="date" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                        id="start_time" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('start_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="end_time" class="form-label">Waktu Selesai</label>
                                    <input type="date" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                        id="end_time" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('end_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="executor" class="form-label">Pelaksana</label>
                                    <input type="text" name="executor" class="form-control @error('executor') is-invalid @enderror"
                                        id="executor" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('executor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="department" class="form-label">Departemen</label>
                                    <input type="text" name="department" class="form-control @error('department') is-invalid @enderror"
                                        id="department" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('department')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="mitigation" class="form-label">Mitigasi</label>
                                    <textarea name="mitigation" class="form-control @error('mitigation') is-invalid @enderror" id="mitigation"
                                        cols="10" rows="3" required></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('mitigation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="impact" class="form-label">Dampak</label>
                                    <textarea name="impact" class="form-control @error('impact') is-invalid @enderror" id="impact"
                                        cols="10" rows="3" required></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('impact')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Status" required>
                                        <option></option>
                                        <option value="Pending">Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="file" class="form-label">Upload File</label>
                                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" id="file" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('file')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route('department.incidental-activities.index') }}" class="btn btn-danger">Cancel</a>
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
