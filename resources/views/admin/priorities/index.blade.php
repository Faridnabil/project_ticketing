@extends('layouts.admin')
@section('content')
    @can('priority_create')
        <div style="padding-top: 20px" class="row">
            <div style="margin-bottom: 10px;" class="col-lg-12">
                <a class="btn btn-success" style="color: white" href="{{ route('admin.priorities.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.priority.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.priority.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Priority">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.priority.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.priority.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.priority.fields.max_time') }}
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($priorities as $key => $priority)
                            <tr data-entry-id="{{ $priority->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $priority->id ?? '' }}
                                </td>
                                <style>
                                    .btn-custom {
                                        border: none;
                                        color: white;
                                        padding: 10px 20px;
                                        text-align: center;
                                        text-decoration: none;
                                        display: inline-block;
                                        font-size: 14px;
                                        margin: 4px 2px;
                                        cursor: pointer;
                                        border-radius: 15px;
                                    }
                                    .btn-critical {
                                        background-color: #dc3545; /* Warna merah */
                                    }
                                    .btn-high {
                                        background-color: #007bff; /* Warna biru */
                                    }
                                    .btn-medium {
                                        background-color: #ffc107; /* Warna kuning */
                                    }
                                    .btn-low {
                                        background-color: #FFA500; /* Warna orange */
                                    }
                                    .btn-low-lvl1 {
                                        background-color: #28A7A7; 
                                        /* color: black;  */
                                    }
                                </style>
                                
                                <td>
                                    @if ($priority->name == 'Critical / Level 2')
                                        <button class="btn-custom btn-critical">{{ $priority->name ?? '' }}</button>
                                    @elseif($priority->name == 'High / Level 2')
                                        <button class="btn-custom btn-high">{{ $priority->name ?? '' }}</button>
                                    @elseif($priority->name == 'Medium / Level 2')
                                        <button class="btn-custom btn-medium">{{ $priority->name ?? '' }}</button>
                                    @elseif($priority->name == 'Low / Level 2')
                                        <button class="btn-custom btn-low">{{ $priority->name ?? '' }}</button>
                                    @elseif($priority->name == 'Low / Level 1')
                                        <button class="btn-custom btn-low-lvl1">{{ $priority->name ?? '' }}</button>
                                    @else
                                        {{ $priority->name ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    {{ $priority->max_time ?? '' }}
                                </td>
                                <td>
                                    @can('priority_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.priorities.show', $priority->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('priority_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.priorities.edit', $priority->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('priority_delete')
                                        <form action="{{ route('admin.priorities.destroy', $priority->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('priority_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.priorities.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            $('.datatable-Priority:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
