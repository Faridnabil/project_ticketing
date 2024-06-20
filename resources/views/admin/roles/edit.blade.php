@extends('layouts.admin')
@section('content')
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
                <small class="text-muted fs-7 fw-bold my-1 ms-1">{{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}
                </small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>
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
                            <div class="col-md-12 pe-lg-10">
                                <div class="card-body">
                                    <form action="{{ route('admin.roles.update', [$role->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                            <label for="title">{{ trans('cruds.role.fields.title') }}*</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="{{ old('title', isset($role) ? $role->title : '') }}" required>
                                            @if ($errors->has('title'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('title') }}
                                                </em>
                                            @endif
                                            <p class="helper-block">
                                                {{ trans('cruds.role.fields.title_helper') }}
                                            </p>
                                        </div>
                                        <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                                            <label for="permissions">{{ trans('cruds.role.fields.permissions') }}*
                                                <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                                                <span
                                                    class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                                            <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple"
                                                required>
                                                @foreach ($permissions as $id => $permissions)
                                                    <option value="{{ $id }}"
                                                        {{ in_array($id, old('permissions', [])) || (isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                                        {{ $permissions }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('permissions'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('permissions') }}
                                                </em>
                                            @endif
                                            <p class="helper-block">
                                                {{ trans('cruds.role.fields.permissions_helper') }}
                                            </p>
                                        </div>
                                        <div>
                                            <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                                        </div>
                                    </form>
                                </div>

                            </div>
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
@endsection
