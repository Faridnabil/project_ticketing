@extends('layouts.admin')
@section('content')

<!--begin::Content-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-place="true" data-kt-place-mode="prepend"
            data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Dashboard
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">   {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="card mb-5 mb-xl-8">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container">
                            <!--begin::Contact-->
                            <div class="card">
                                <!--begin::Body-->
                                <div class="card-body p-lg-17">
                                    <!--begin::Row-->
                                    <div class="row mb-3">
                                        <!--begin::Col-->
                                        <form action="{{ route('admin.users.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <label for="name" class="fs-5 fw-bold mb-2">{{ trans('cruds.user.fields.name') }}</label>
                                            <input type="text" id="name" name="name"
                                                class="form-control form-control-solid"
                                                value="{{ old('name', isset($user) ? $user->name : '') }}"
                                                required>
                                            @if ($errors->has('name'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </em>
                                            @endif
                                            <p class="helper-block">
                                                {{ trans('cruds.user.fields.name_helper') }}
                                            </p>
                                        </div>
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                            <label
                                                for="email" class="fs-5 fw-bold mb-2">{{ trans('cruds.user.fields.email') }}</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-solid"
                                                value="{{ old('email', isset($user) ? $user->email : '') }}"
                                                required>
                                            @if ($errors->has('email'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </em>
                                            @endif
                                            <p class="helper-block">
                                                {{ trans('cruds.user.fields.email_helper') }}
                                            </p>
                                        </div>
                                        <div
                                            class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                            <label
                                                for="password" class="fs-5 fw-bold mb-2">{{ trans('cruds.user.fields.password') }}</label>
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-solid" required>
                                            @if ($errors->has('password'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </em>
                                            @endif
                                            <p class="helper-block">
                                                {{ trans('cruds.user.fields.password_helper') }}
                                            </p>
                                        </div>
                                        <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                                            <label for="roles" class="fs-5 fw-bold mb-2">{{ trans('cruds.user.fields.roles') }}*
                                                <span
                                                    class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                                                <span
                                                    class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                                            <select name="roles[]" id="roles" class="form-control select2"
                                                multiple="multiple" required>
                                                @foreach ($roles as $id => $roles)
                                                    <option value="{{ $id }}"
                                                        {{ in_array($id, old('roles', [])) || (isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                                        {{ $roles }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('roles'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('roles') }}
                                                </em>
                                            @endif
                                            <p class="helper-block">
                                                {{ trans('cruds.user.fields.roles_helper') }}
                                            </p>
                                        </div>
                                        <div>
                                            <input class="btn btn-danger" type="submit"
                                                value="{{ trans('global.save') }}">
                                        </div>
                                    </form>
                                    </div>
                                    <!--end::Row-->

                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Contact-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->

@endsection
