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
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Menu
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">   {{ trans('global.create') }} {{ trans('cruds.priority.title_singular') }}</small>
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
                                        <form action="{{ route('admin.priorities.update', [$priority->id]) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                <label for="name">{{ trans('cruds.priority.fields.name') }}*</label>
                                                <input type="text" id="name" name="name" class="form-control form-control-solid"
                                                    value="{{ old('name', isset($priority) ? $priority->name : '') }}" required>
                                                @if ($errors->has('name'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.priority.fields.name_helper') }}
                                                </p>
                                            </div>
                                            <div class="form-group {{ $errors->has('max_time') ? 'has-error' : '' }}">
                                                <label for="max_time">{{ trans('cruds.priority.fields.max_time') }}*</label>
                                                <input type="text" id="max_time" name="max_time" class="form-control form-control-solid"
                                                    value="{{ old('max_time', isset($priority) ? $priority->max_time : '') }}">
                                                @if ($errors->has('max_time'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('max_time') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.priority.fields.max_time_helper') }}
                                                </p>
                                            </div>
                                            {{-- <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
                                        <label for="color">{{ trans('cruds.priority.fields.color') }}</label>
                                        <input type="text" id="color" name="color" class="form-control colorpicker" value="{{ old('color', isset($priority) ? $priority->color : '') }}">
                                        @if ($errors->has('color'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('color') }}
                                            </em>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.priority.fields.color_helper') }}
                                        </p>
                                    </div> --}}
                                            <div>
                                                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
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
