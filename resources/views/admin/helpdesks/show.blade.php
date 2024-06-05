@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.helpdesk.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.helpdesk.fields.id') }}
                        </th>
                        <td>
                            {{ $helpdesk->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpdesk.fields.subject') }}
                        </th>
                        <td>
                            {{ $helpdesk->subject ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpdesk.fields.emailAddress') }}
                        </th>
                        <td>
                            {{ $helpdesk->email_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpdesk.fields.message') }}
                        </th>
                        <td>
                            {{ $helpdesk->message }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpdesk.fields.user') }}
                        </th>
                        <td>
                            {{ $helpdesk->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpdesk.fields.priority') }}
                        </th>
                        <td>
                            {!! $helpdesk->priority->name ?? '' !!}
                        </td>
                    </tr>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.helpdesk.fields.category') }}
                            </th>
                            <td>
                                {!! $helpdesk->category->name ?? '' !!}
                            </td>
                        </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.helpdesk.fields.created_at') }}
                        </th>
                        <td>
                            {!! $helpdesk->created_at !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection