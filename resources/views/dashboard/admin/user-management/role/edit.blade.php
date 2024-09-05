@extends('layouts.dashboard.app')

@section('title')
    Ubah Peran | PLN Icon+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <a href="{{ route('role.index') }}" class="btn btn-custom">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Peran</h4>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
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
                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('role.update', $role->id) }}" enctype="multipart/form-data" novalidate>
                                    @method('PUT')
                                    @csrf

                                    <div class="col-md-6">
                                        <label for="validationCustom01" class="form-label">Role</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror mb-4"
                                            id="name" name="name" value="{{ old('name', $role->name) }}" autofocus
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

                                    <!--begin::Input group Permission-->
                                    <div class="col-md-11">
                                        <div class="role-permissions">
                                            <div class="row">
                                                @if (count($permission))
                                                    @foreach ($permission as $item)
                                                        <!-- Assuming you want 3 permissions per row -->
                                                        <div class="col-md-4">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input mb-4" type="checkbox"
                                                                    name="permission[]"
                                                                    id="inlineCheckbox{{ $item->id }}"
                                                                    value="{{ $item->id }}"
                                                                    {{ in_array($item->id, $rolePermissions) ? 'checked="checked"' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox{{ $item->id }}">{{ $item->name }}</label>
                                                            </div>
                                                        </div>
                                                        @if ($loop->index % 3 == 2)
                                            </div>
                                            <div class="row">
                                                @endif
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group Permission-->

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a href="{{ route('role.index') }}" class="btn btn-danger">Cancel</a>
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
@endsection
