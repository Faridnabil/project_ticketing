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
                <small class="text-muted fs-7 fw-bold my-1 ms-1"> {{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }}</small>
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

                                <form action="{{ route("admin.permissions.store") }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                        <label class="fs-5 fw-bold mb-2">{{ trans('cruds.permission.fields.title') }}</label>
                                        <input type="text" id="title" name="title"  class="form-control form-control-solid" value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                                        @if($errors->has('title'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('title') }}
                                            </em>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.permission.fields.title_helper') }}
                                        </p>
                                    </div>
                                    <div>
                                        <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                                    </div>
                                </form>

                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 ps-lg-10">

                            </div>
                            <!--end::Col-->
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
