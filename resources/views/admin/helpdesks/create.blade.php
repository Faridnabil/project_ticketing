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
                <small class="text-muted fs-7 fw-bold my-1 ms-1">   {{ trans('global.create') }} {{ trans('cruds.helpdesk.title_singular') }}</small>
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
                                        <form action="{{ route('admin.helpdesks.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            {{-- ? fixx --}}
                                            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                                                <label for="subject">{{ trans('cruds.helpdesk.fields.subject') }}*</label>
                                                <input type="text" id="subject" name="subject" class="form-control"
                                                    value="{{ old('subject', isset($helpdesk) ? $helpdesk->subject : '') }}" required>
                                                @if ($errors->has('subject'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('subject') }}
                                                    </em>
                                                @endif
                                                {{-- <p class="helper-block">
                                            {{ trans('cruds.helpdesk.fields.subject') }}
                                        </p> --}}
                                            </div>
                                            <div class="form-group {{ $errors->has('email_address') ? 'has-error' : '' }}">
                                                <label for="email_address">{{ trans('cruds.helpdesk.fields.emailAddress') }}*</label>
                                                <input type="email" id="email_address" name="email_address" class="form-control"
                                                    value="{{ old('email_address', isset($helpdesk) ? $helpdesk->email_address : '') }}" required>
                                                @if ($errors->has('email_address'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('email_address') }}
                                                    </em>
                                                @endif
                                                {{-- <p class="helper-block">
                                            {{ trans('cruds.helpdesk.fields.emailAddress') }}
                                        </p> --}}
                                            </div>
                                            <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                                                <label for="message">{{ trans('cruds.helpdesk.fields.message') }}*</label>
                                                <textarea id="message" name="message" class="form-control " required>{{ old('message', isset($helpdesk) ? $helpdesk->message : '') }}</textarea>
                                                @if ($errors->has('message'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('message') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.helpdesk.fields.message') }}
                                                </p>
                                            </div>
                                            <div class="form-group {{ $errors->has('priority_id') ? 'has-error' : '' }}">
                                                <label for="priority_id">{{ trans('cruds.helpdesk.fields.priority') }}</label>
                                                <select name="priority_id" id="priority_id" class="form-select" data-control="select2">
                                                    @foreach ($priorities as $id => $priority)
                                                        <option value="{{ $id }}"
                                                            {{ (isset($helpdesk) && $helpdesk->priorities->name ? $helpdesk->priorities->name : old('priority_id')) == $id ? 'selected' : '' }}>
                                                            {{ $priority }} </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('priority_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('priority_id') }}
                                                    </em>
                                                @endif
                                            </div>
                                            {{-- ? endfixx --}}

                                            <div class="form-group {{ $errors->has('ticket_id') ? 'has-error' : '' }}">
                                                <label for="ticket_id">{{ trans('cruds.helpdesk.fields.ticket_id') }}</label>
                                                <select name="ticket_id" id="ticket_id" class="form-select" data-control="select2">
                                                    @foreach ($tickets as $ticket_id => $ticket_name)
                                                        <option value="{{ $ticket_name->ticket_id }}"
                                                            {{ old('ticket_id') == $ticket_id ? 'selected' : '' }}>
                                                            {{ $ticket_name->ticket_id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('ticket_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('ticket_id') }}
                                                    </em>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                                <label for="user">{{ trans('cruds.helpdesk.fields.user') }}</label>
                                                <select name="user_id" id="user"  class="form-select" data-control="select2">
                                                    @foreach ($users as $id => $user)
                                                        <option value="{{ $id }}"
                                                            {{ (isset($helpdesk) && $helpdesk->user ? $helpdesk->user->id : old('user_id')) == $id ? 'selected' : '' }}>
                                                            {{ $user }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('user_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('user_id') }}
                                                    </em>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('status_id') ? 'has-error' : '' }}" style="display: none;">
                                                <label for="status_id">{{ trans('cruds.helpdesk.fields.status') }}</label>
                                                <select name="status_id" id="status_id" class="form-control form-control-solid" disabled>
                                                    @foreach ($statuses as $id => $status)
                                                        <option value="{{ $id }}" {{ $id == $openStatusId ? 'selected' : '' }}>
                                                            {{ $status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('status_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('status_id') }}
                                                    </em>
                                                @endif
                                            </div>

                                            <!-- Tambahkan input tersembunyi -->
                                            <input type="hidden" name="status_id" value="{{ $openStatusId }}">

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
