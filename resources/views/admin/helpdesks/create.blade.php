@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.helpdesk.title_singular') }}
        </div>

        <div class="card-body">
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
                    <select name="priority_id" id="priority_id" class="form-control select2">
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
                    <select name="ticket_id" id="ticket_id" class="form-control select2">
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
                    <select name="user_id" id="user" class="form-control select2">
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
                <div class="form-group {{ $errors->has('status_id') ? 'has-error' : '' }}">
                    <label for="status_id">{{ trans('cruds.helpdesk.fields.status') }}</label>
                    <select name="status_id" id="user" class="form-control select2">
                        @foreach ($statuses as $id => $status)
                            <option value="{{ $id }}"
                                {{ (isset($helpdesk) && $helpdesk->status_id ? $helpdesk->status_id : old('user_id')) == $id ? 'selected' : '' }}>
                                {{ $status }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('user_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('user_id') }}
                        </em>
                    @endif
                </div>

                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
