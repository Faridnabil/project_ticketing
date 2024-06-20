@extends('layouts.admin')
@section('content')
    <div style="padding-top: 20px" class="content">
        <div style="margin-top: 50px" class="card">
            <div class="card-header">
                {{ trans('global.create') }} {{ trans('cruds.ticket.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="ticket_id" name="ticket_id" hidden>

                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title">{{ trans('cruds.ticket.fields.title') }}*</label>
                        <input type="text" id="title" name="title" class="form-control"
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
                        <textarea id="content" name="content" class="form-control ">{{ old('content', isset($ticket) ? $ticket->content : '') }}</textarea>
                        @if ($errors->has('content'))
                            <em class="invalid-feedback">
                                {{ $errors->first('content') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.ticket.fields.content_helper') }}
                        </p>
                    </div>

                    <div class="fv-row">
                        <div class="dropzone" id="kt_dropzonejs_example_1">
                            <div class="dz-message needsclick">
                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                    <span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
                                </div>
                            </div>
                        </div>
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
                        <input type="text" id="author_name" name="author_name" class="form-control"
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
                        <input type="text" id="author_email" name="author_email" class="form-control"
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
        </div>
    </div>
@endsection

