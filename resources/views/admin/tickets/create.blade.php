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
                <small class="text-muted fs-7 fw-bold my-1 ms-1">   {{ trans('global.create') }} {{ trans('cruds.ticket.title_singular') }}</small>
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
                                        <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" id="ticket_id" name="ticket_id" hidden>

                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="title">{{ trans('cruds.ticket.fields.title') }}*</label>
                                                <input type="text" id="title" name="title" class="form-control form-control-solid"
                                                    value="{{ old('title', isset($ticket) ? $ticket->title : '') }}" required>
                                                @if ($errors->has('title'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('title') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.ticket.fields.title_helper') }}
                                                </p>
                                            </div>

                                            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                                <label for="content">{{ trans('cruds.ticket.fields.content') }}</label>
                                                <textarea id="content" name="content" class="form-control form-control-solid">{{ old('content', isset($ticket) ? $ticket->content : '') }}</textarea>
                                                @if ($errors->has('content'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('content') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.ticket.fields.content_helper') }}
                                                </p>
                                            </div>

                                            <div class="form-group {{ $errors->has('attachments') ? 'has-error' : '' }}">
                                                <label for="attachments">{{ trans('cruds.ticket.fields.attachments') }}</label>
                                                <div class="needsclick dropzone" id="attachments-dropzone">

                                                </div>
                                                @if ($errors->has('attachments'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('attachments') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.ticket.fields.attachments_helper') }}
                                                </p>
                                            </div>

                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                                <label for="category">{{ trans('cruds.ticket.fields.category') }}*</label>
                                                <select name="category_id" id="category" class="form-control select2" required>
                                                    @foreach ($categories as $id => $category)
                                                        <option value="{{ $id }}"
                                                            {{ (isset($ticket) && $ticket->category ? $ticket->category->id : old('category_id')) == $id ? 'selected' : '' }}>
                                                            {{ $category }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('category_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('category_id') }}
                                                    </em>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('author_name') ? 'has-error' : '' }}">
                                                <label for="author_name">{{ trans('cruds.ticket.fields.author_name') }}</label>
                                                <input type="text" id="author_name" name="author_name" class="form-control form-control-solid"
                                                    value="{{ old('author_name', isset($ticket) ? $ticket->author_name : '') }}">
                                                @if ($errors->has('author_name'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('author_name') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.ticket.fields.author_name_helper') }}
                                                </p>
                                            </div>

                                            <div class="form-group {{ $errors->has('author_email') ? 'has-error' : '' }}">
                                                <label for="author_email">{{ trans('cruds.ticket.fields.author_email') }}</label>
                                                <input type="text" id="author_email" name="author_email" class="form-control form-control-solid"
                                                    value="{{ old('author_email', isset($ticket) ? $ticket->author_email : '') }}">
                                                @if ($errors->has('author_email'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('author_email') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.ticket.fields.author_email_helper') }}
                                                </p>
                                            </div>

                                            @if (auth()->user()->isAdmin())
                                                <div class="form-group {{ $errors->has('assigned_to_user_id') ? 'has-error' : '' }}">
                                                    <label for="assigned_to_user">{{ trans('cruds.ticket.fields.assigned_to_user') }}</label>
                                                    <select name="assigned_to_user_id" id="assigned_to_user" class="form-control select2">
                                                        @foreach ($assigned_to_users as $id => $assigned_to_user)
                                                            <option value="{{ $id }}"
                                                                {{ (isset($ticket) && $ticket->assigned_to_user ? $ticket->assigned_to_user->id : old('assigned_to_user_id')) == $id ? 'selected' : '' }}>
                                                                {{ $assigned_to_user }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('assigned_to_user_id'))
                                                        <em class="invalid-feedback">
                                                            {{ $errors->first('assigned_to_user_id') }}
                                                        </em>
                                                    @endif
                                                </div>
                                            @endif

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
