@extends('layouts.dashboard.app')

@section('title')
    Ubah Pengguna | SIAK Dukcapil
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
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Ubah Pengguna</small>
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
                                action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data" novalidate>
                                @method('PUT')
                                @csrf
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" autofocus
                                        required>

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
                                        id="email" name="email" value="{{ old('email', $user->email) }}" autofocus
                                        required>

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
                                        id="password" name="password" autofocus>

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
                                        id="password_confirmation" autofocus>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom04" class="form-label">Roles</label>
                                    <select class="form-select @error('roles') is-invalid @enderror" name="roles[]"
                                        id="default" required>
                                        <option selected disabled> Select Role </option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item }}"
                                                @if ($user->hasRole($item)) selected @endif>{{ $item }}
                                            </option>
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
                                        id="default" required>
                                        <option selected disabled> Select Gender </option>
                                        @if ($user->gender == 'Pria')
                                            <option value="Pria" selected>Pria</option>
                                            <option value="Wanita">Wanita</option>
                                        @else
                                            <option value="Wanita" selected>Wanita</option>
                                            <option value="Pria">Pria</option>
                                        @endif
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
                                    <label class="d-block fw-bold fs-6 mb-5">Foto Profil</label>

                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline" data-kt-image-input="true"
                                         style="background-image: url('{{ asset($user->photo ? $user->photo : 'assets/media/avatars/blank.png') }}')">

                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px"
                                             style="background-image: url('{{ asset($user->photo ? $user->photo : 'assets/media/avatars/blank.png') }}');">
                                        </div>
                                        <!--end::Preview existing avatar-->

                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
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
                    <!--end::List Widget 1-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
@endsection
