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
                            <div class="card mb-5 mb-xl-8">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.priority.fields.id') }}
                                                    </th>
                                                    <td>
                                                        {{ $priority->id }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.priority.fields.name') }}
                                                    </th>
                                                    <td>
                                                        {{ $priority->name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.priority.fields.max_time') }}
                                                    </th>
                                                    <td>
                                                        {{ $priority->max_time }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <a style="margin-top:20px;" class="btn btn-secondary" href="{{ url()->previous() }}">
                                            {{ trans('global.back_to_list') }}
                                        </a>
                                    </div>

                                    <nav class="mb-3">
                                        <div class="nav nav-tabs">

                                        </div>
                                    </nav>
                                    <div class="tab-content">

                                    </div>
                                </div>
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
