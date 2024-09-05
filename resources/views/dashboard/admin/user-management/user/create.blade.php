@extends('layouts.dashboard.app')

@section('title')
    Tambah Pengguna | PLN Icon+
@endsection

<style>
    .image-input-wrapper {
        width: 125px;
        height: 125px;
        background-size: cover;
        background-position: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        position: relative;
    }
</style>
@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="d-flex justify-content-start mb-1">
                <a href="{{ route('user.index') }}" class="btn btn-custom">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Tambah User</h4>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <form class="row g-3 needs-validation" method="POST" action="{{ route('user.store') }}"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" autofocus required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom02" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" autofocus required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationCustom02" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" autofocus required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationCustom02" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" autofocus required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationCustom04" class="form-label">Roles</label>
                                        <select class="form-select @error('roles') is-invalid @enderror" name="roles[]"
                                            id="select-field" required>
                                            <option selected disabled> Select Role </option>
                                            @foreach ($roles as $item)
                                                @if ($item == 'Super Admin')
                                                @else
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <!--end col-->
                                    <div class="col-md-6">
                                        <label for="validationCustom04" class="form-label">Gender</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" name="gender"
                                            id="select-field2" required>
                                            <option selected disabled> Select Gender </option>
                                            <option value="Man">Pria</option>
                                            <option value="Woman">Wanita</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <br>
                                    <!--end col-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="d-block fw-bold fs-6 mb-2">Foto Profil</label>

                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline" data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px mb-3" id="imagePreview"
                                                style="background-image: url('assets/media/avatars/blank.png');
                                                    background-size: cover;
                                                    background-position: center;">
                                            </div>
                                            <input type="file" name="photo" accept=".png, .jpg, .jpeg"
                                                id="photoInput" />
                                            <input type="hidden" name="photo" />
                                            <!--end::Label-->
                                            <!--begin::Cancel-->
                                        </div>
                                        <!--end::Image input-->
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a href="{{ route('user.index') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </form><!--end form-->
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
    <script>
        document.getElementById('photoInput').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').style.backgroundImage = 'url(' + e.target.result +
                        ')';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
