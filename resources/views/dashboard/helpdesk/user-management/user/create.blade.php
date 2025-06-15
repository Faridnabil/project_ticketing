@extends('layouts.dashboard.app')

@section('title')
    Tambah Pengguna | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Pengguna
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Tambah Pengguna</small>
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
                            <form class="row g-3 needs-validation" method="POST" action="{{ route('helpdesk.user.store') }}"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" autofocus required>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" name="nik" value="{{ old('nik') }}" autofocus required>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="validationCustom02" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" autofocus required>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom02" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" autofocus required>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom02" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" autofocus required>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom04" class="form-label">Roles</label>
                                    <select class="form-select @error('roles') is-invalid @enderror" name="roles[]"
                                        data-control="select2" id="select-field2" data-placeholder="Pilih Role" required>
                                        @foreach ($roles as $item)
                                            @if ($item != 'Super Helpdesk' && $item != 'Super Admin')
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom04" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" name="gender"
                                        data-control="select2" id="select-field2" data-placeholder="Pilih Jenis Kelamin"
                                        required>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block fw-bold fs-6 mb-5">Foto Profil</label>
                                    <div class="image-input image-input-outline" data-kt-image-input="true"
                                        style="background-image: url(assets/media/avatars/blank.png)">
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url(assets/media/avatars/150-1.jpg);"></div>
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="photo" />
                                        </label>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block fw-bold fs-6 mb-5">Upload Surat Tugas</label>
                                    <div class="custom-file-upload"
                                        style="display: flex; align-items: center; gap: 10px;   border: 1px solid #ccc; border-radius: 5px;background-color: #f9f9f9;">
                                        <label for="fileInput" class="upload-label"
                                            style="display: flex;align-items: center;   font-weight: bold;cursor: pointer;">
                                            <span class="upload-button"
                                                style="background-color: #0069d9;font-size: 14px; color: #fff;  white-space: nowrap;  padding: 6px 12px;border-radius: 4px;">Unggah
                                                file</span>
                                            <span id="fileName" style="margin-left: 10px">Tidak ada
                                                file dipilih</span>
                                        </label>
                                        <input id="fileInput" type="file" name="surat_tugas" style="display: none;"
                                            accept=".pdf">
                                    </div>

                                    <script>
                                        document.getElementById('fileInput').addEventListener('change', function(event) {
                                            const fileName = event.target.files[0]?.name || 'Tidak ada file dipilih';
                                            document.getElementById('fileName').textContent = fileName;
                                        });
                                    </script>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
