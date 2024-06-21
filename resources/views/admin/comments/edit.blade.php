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
                <small class="text-muted fs-7 fw-bold my-1 ms-1">   {{ trans('global.create') }} {{ trans('cruds.comment.title_singular') }}</small>
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
                                        <form action="{{ route('admin.comments.update', [$comment->id]) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group {{ $errors->has('ticket_id') ? 'has-error' : '' }}">
                                                <label for="ticket">{{ trans('cruds.comment.fields.ticket') }}</label>
                                                <select name="ticket_id" id="ticket" class="form-control select2">
                                                    @foreach ($tickets as $id => $ticket)
                                                        <option value="{{ $id }}"
                                                            {{ (isset($comment) && $comment->ticket ? $comment->ticket->id : old('ticket_id')) == $id ? 'selected' : '' }}>
                                                            {{ $ticket }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('ticket_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('ticket_id') }}
                                                    </em>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('author_name') ? 'has-error' : '' }}">
                                                <label for="author_name">{{ trans('cruds.comment.fields.author_name') }}*</label>
                                                <input type="text" id="author_name" name="author_name" class="form-control"
                                                    value="{{ old('author_name', isset($comment) ? $comment->author_name : '') }}" required>
                                                @if ($errors->has('author_name'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('author_name') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.comment.fields.author_name_helper') }}
                                                </p>
                                            </div>
                                            <div class="form-group {{ $errors->has('author_email') ? 'has-error' : '' }}">
                                                <label for="author_email">{{ trans('cruds.comment.fields.author_email') }}*</label>
                                                <input type="text" id="author_email" name="author_email" class="form-control"
                                                    value="{{ old('author_email', isset($comment) ? $comment->author_email : '') }}" required>
                                                @if ($errors->has('author_email'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('author_email') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.comment.fields.author_email_helper') }}
                                                </p>
                                            </div>
                                            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                                <label for="user">{{ trans('cruds.comment.fields.user') }}</label>
                                                <select name="user_id" id="user" class="form-control select2">
                                                    @foreach ($users as $id => $user)
                                                        <option value="{{ $id }}"
                                                            {{ (isset($comment) && $comment->user ? $comment->user->id : old('user_id')) == $id ? 'selected' : '' }}>
                                                            {{ $user }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('user_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('user_id') }}
                                                    </em>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('comment_text') ? 'has-error' : '' }}">
                                                <label for="comment_text">{{ trans('cruds.comment.fields.comment_text') }}*</label>
                                                <textarea id="comment_text" name="comment_text" class="form-control " required>{{ old('comment_text', isset($comment) ? $comment->comment_text : '') }}</textarea>
                                                @if ($errors->has('comment_text'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('comment_text') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.comment.fields.comment_text_helper') }}
                                                </p>
                                            </div>
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
