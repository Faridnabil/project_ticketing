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
                    <small class="text-muted fs-7 fw-bold my-1 ms-1"> {{ trans('global.create') }}
                        {{ trans('cruds.ticket.title_singular') }}</small>
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
                                    <div class="card-body">
                                        <form action="{{ route('admin.tickets.update', [$ticket->id]) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group {{ $errors->has('ticket_id') ? 'has-error' : '' }}">
                                                <label for="ticket_id">{{ trans('cruds.ticket.fields.ticket_id') }}*</label>
                                                <input type="text" id="ticket_id" name="ticket_id"
                                                    class="form-control form-control-solid"
                                                    value="{{ old('ticket_id', isset($ticket) ? $ticket->ticket_id : '') }}"
                                                    required pattern="TICK-\d{6}" placeholder="TICK-123456"
                                                    title="TICK-123456">
                                                @if ($errors->has('ticket_id'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('ticket_id') }}
                                                    </em>
                                                @endif
                                                <p class="helper-block">
                                                    {{ trans('cruds.ticket.fields.ticket_id_helper') }}
                                                </p>
                                            </div>

                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="title">{{ trans('cruds.ticket.fields.title') }}*</label>
                                                <input type="text" id="title" name="title"
                                                    class="form-control form-control-solid"
                                                    value="{{ old('title', isset($ticket) ? $ticket->title : '') }}"
                                                    required>
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
                                            <!--begin::Input group-->
                                            <div class="fv-row">
                                                <!--begin::Dropzone-->
                                                <div
                                                    class="form-group {{ $errors->has('attachments') ? 'has-error' : '' }}">
                                                    <label
                                                        for="attachments">{{ trans('cruds.ticket.fields.attachments') }}</label>
                                                    <div class="needsclick dropzone" id="attachments-dropzone">
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick">
                                                            <!--begin::Icon-->
                                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <!--end::Icon-->

                                                            <!--begin::Info-->
                                                            <div class="ms-4">
                                                                <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files
                                                                    here or click to upload.</h3>
                                                                <span class="fs-7 fw-bold text-gray-400">Upload up to 10
                                                                    files</span>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
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
                                                <!--end::Dropzone-->
                                            </div>
                                            <!--end::Input group-->
                                            {{-- <div class="form-group {{ $errors->has('status_id') ? 'has-error' : '' }}">
                                            <label for="status">{{ trans('cruds.ticket.fields.status') }}*</label>
                                            <select name="status_id" id="status" class="form-control select2" required>
                                                @foreach ($statuses as $id => $status)
                                                    <option value="{{ $id }}"
                                                        {{ (isset($ticket) && $ticket->status ? $ticket->status->id : old('status_id')) == $id ? 'selected' : '' }}>
                                                        {{ $status }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('status_id'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('status_id') }}
                                                </em>
                                            @endif
                                        </div> --}}
                                            {{-- <div class="form-group {{ $errors->has('priority_id') ? 'has-error' : '' }}">
                                            <label for="priority">{{ trans('cruds.ticket.fields.priority') }}*</label>
                                            <select name="priority_id" id="priority" class="form-control select2" required>
                                                @foreach ($priorities as $id => $priority)
                                                    <option value="{{ $id }}"
                                                        {{ (isset($ticket) && $ticket->priority ? $ticket->priority->id : old('priority_id')) == $id ? 'selected' : '' }}>
                                                        {{ $priority }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('priority_id'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('priority_id') }}
                                                </em>
                                            @endif
                                        </div> --}}
                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                                <label for="category">{{ trans('cruds.ticket.fields.category') }}*</label>
                                                <select name="category_id" id="category"  class="form-select" data-control="select2"
                                                    required>
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
                                                <label
                                                    for="author_name">{{ trans('cruds.ticket.fields.author_name') }}</label>
                                                <input type="text" id="author_name" name="author_name"
                                                    class="form-control form-control-solid"
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
                                                <label
                                                    for="author_email">{{ trans('cruds.ticket.fields.author_email') }}</label>
                                                <input type="text" id="author_email" name="author_email"
                                                    class="form-control form-control-solid"
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
                                                <div
                                                    class="form-group {{ $errors->has('assigned_to_user_id') ? 'has-error' : '' }}">
                                                    <label
                                                        for="assigned_to_user">{{ trans('cruds.ticket.fields.assigned_to_user') }}</label>
                                                    <select name="assigned_to_user_id" id="assigned_to_user"
                                                         class="form-select" data-control="select2">
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
                                                <input class="btn btn-danger" type="submit"
                                                    value="{{ trans('global.save') }}">
                                            </div>
                                        </form>


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

@section('scripts')

    <script>
        var uploadedAttachmentsMap = {}
        Dropzone.options.attachmentsDropzone = {
            url: '{{ route('admin.tickets.storeMedia') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
                uploadedAttachmentsMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedAttachmentsMap[file.name]
                }
                $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($ticket) && $ticket->attachments)
                    var files =
                        {!! json_encode($ticket->attachments) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name +
                            '">')
                    }
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@stop
