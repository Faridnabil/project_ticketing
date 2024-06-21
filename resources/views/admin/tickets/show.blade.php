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
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="mb-2">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $ticket->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $ticket->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.ticket_id') }}
                                    </th>
                                    <td>
                                        {{ $ticket->ticket_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $ticket->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.content') }}
                                    </th>
                                    <td>
                                        {!! $ticket->content !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.attachments') }}
                                    </th>
                                    <td>
                                        @foreach ($ticket->attachments as $attachment)
                                            <a href="{{ $attachment->getUrl() }}"
                                                target="_blank">{{ $attachment->file_name }}</a>
                                        @endforeach
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.status') }}
                                    </th>
                                    <td>
                                        {{ $ticket->status->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.priority') }}
                                    </th>
                                    <td>
                                        {{ $ticket->priority->name ?? '' }}
                                    </td>
                                </tr> --}}
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.category') }}
                                    </th>
                                    <td>
                                        {{ $ticket->category->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.author_name') }}
                                    </th>
                                    <td>
                                        {{ $ticket->author_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.author_email') }}
                                    </th>
                                    <td>
                                        {{ $ticket->author_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.assigned_to_user') }}
                                    </th>
                                    <td>
                                        {{ $ticket->assigned_to_user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.ticket.fields.comments') }}
                                    </th>
                                    <td>
                                        @forelse ($ticket->comments as $comment)
                                            <div class="row">
                                                <div class="col">
                                                    <p class="font-weight-bold"><a
                                                            href="mailto:{{ $comment->author_email }}">{{ $comment->author_name }}</a>
                                                        ({{ $comment->created_at }})
                                                    </p>
                                                    <p>{{ $comment->comment_text }}</p>
                                                </div>
                                            </div>
                                            <hr />
                                        @empty
                                            <div class="row">
                                                <div class="col">
                                                    <p>There are no comments.</p>
                                                </div>
                                            </div>
                                            <hr />
                                        @endforelse
                                        <form action="{{ route('admin.tickets.storeComment', $ticket->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="comment_text">Leave a comment</label>
                                                <textarea class="form-control" id="comment_text" name="comment_text" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a class="btn btn-secondary my-2" href="{{ route('admin.tickets.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>

                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-primary">
                        @lang('global.edit') @lang('cruds.ticket.title_singular')
                    </a>

                    <nav class="mb-3">
                        <div class="nav nav-tabs">

                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->

@endsection
