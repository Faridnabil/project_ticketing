@extends('layouts.admin')
@section('content')
    @can('helpdesk_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.helpdesks.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.helpdesk.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.helpdesk.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Comment">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>{{ trans('cruds.helpdesk.fields.id') }}</th>
                            <th>{{ trans('cruds.helpdesk.fields.ticket_id') }}</th>
                            <th>{{ trans('cruds.helpdesk.fields.subject') }}</th>
                            <th>{{ trans('cruds.helpdesk.fields.emailAddress') }}</th>
                            <th>{{ trans('cruds.helpdesk.fields.message') }}</th>
                            <th>{{ trans('cruds.helpdesk.fields.priority') }}</th>
                            <th>Eskalasi (Jam)</th>
                            <th>Hitungan Mundur</th>
                            {{-- <th>{{ trans('cruds.helpdesk.fields.category') }}</th> --}}
                            <th>{{ trans('cruds.helpdesk.fields.user') }}</th>
                            <th>{{ trans('cruds.helpdesk.fields.status') }}</th>
                            <th>{{ trans('cruds.helpdesk.fields.created_at') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($helpdesks as $key => $helpdesk)
                            <tr data-entry-id="{{ $helpdesk->id }}">
                                <td></td>
                                <td>{{ $helpdesk->id ?? '' }}</td>
                                <td>{{ $helpdesk->ticket_id ?? '' }}</td>
                                <td>{{ $helpdesk->subject ?? '' }}</td>
                                <td>{{ $helpdesk->email_address ?? '' }}</td>
                                <td>{{ $helpdesk->message ?? '' }}</td>
                                <td>
                                    @if ($helpdesk->priority->name == 'Critical')
                                        <button class="btn btn-danger">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @elseif($helpdesk->priority->name == 'High')
                                        <button class="btn btn-primary">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @elseif($helpdesk->priority->name == 'Medium')
                                        <button class="btn btn-warning">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @elseif($helpdesk->priority->name == 'Low')
                                        <button class="btn btn-success">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @else
                                        {{ $helpdesk->priority->name ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($helpdesk->priority->escalation_time) &&
                                            $helpdesk->priority->escalation_time != '-' &&
                                            $helpdesk->priority->escalation_time != 0.0013888888888889)
                                        {{ $helpdesk->priority->escalation_time }} Jam
                                    @else
                                        {{ $helpdesk->priority->escalation_time ?? '' }}
                                    @endif
                                    @php
                                        $isLowLevel1 = $helpdesk->priority->name == 'Low / Level 1';
                                    @endphp

                                    @if ($isLowLevel1)
                                        @php
                                            $helpdesk->status->name = 'Closed';
                                        @endphp
                                    @endif
                                </td>

                                <td>
                                    @if ($helpdesk->priority->escalation_time != '-' && $helpdesk->priority->escalation_time != 0.0013888888888889)
                                        <span class="countdown" data-entry-id="{{ $helpdesk->id }}"
                                            data-created-at="{{ $helpdesk->created_at }}"
                                            data-escalation-time="{{ $helpdesk->priority->escalation_time }}"></span>
                                    @endif
                                </td>
                                {{-- <td>{{ $helpdesk->category->name ?? '' }}</td> --}}
                                <td>{{ $helpdesk->user->name ?? '' }}</td>
                                <td>
                                    @if ($helpdesk->status->name == 'Open')
                                        <button class="btn btn-success">{{ $helpdesk->status->name ?? '' }}</button>
                                    @elseif($helpdesk->status->name == 'Closed')
                                        <button class="btn btn-danger">{{ $helpdesk->status->name ?? '' }}</button>
                                    @else
                                        {{ $helpdesk->status->name ?? '' }}
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($helpdesk->created_at)->timezone('Asia/Jakarta')->locale('id')->isoFormat('LLLL') ?? '' }}
                                </td>
                                <td>
                                    @can('helpdesk_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.helpdesks.show', $helpdesk->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('helpdesk_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.helpdesks.edit', $helpdesk->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('helpdesk_delete')
                                        <form action="{{ route('admin.helpdesks.destroy', $helpdesk->id) }}" method="POST"
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
        // Fungsi tables tab Start
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('helpdesk_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.helpdesks.massDestroy') }}",
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
            $('.datatable-Comment:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
        // Fungsi tables tab End

        // Fungsi countdown
        function calculateTimeDifference(createdAt, escalationHours) {
            const createdDate = new Date(createdAt);
            const escalationTime = createdDate.getTime() + (escalationHours * 60 * 60 * 1000);
            const now = new Date().getTime();
            const timeLeft = escalationTime - now;

            if (timeLeft <= 0) {
                return "00:00:00";
            }

            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        function updateStatusToClosed(helpdeskId) {
            $.ajax({
                url: `helpdesks/${helpdeskId}/close`,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Status updated to closed');
                    } else {
                        console.error('Failed to update status:', response);
                    }
                },
                error: function(xhr) {
                    console.error('Failed to update status:', xhr);
                }
            });
        }

        function startCountdown() {
            document.querySelectorAll('.countdown').forEach(function(element) {
                const createdAt = element.getAttribute('data-created-at');
                const escalationTime = parseInt(element.getAttribute('data-escalation-time'), 10);
                const helpdeskId = element.getAttribute('data-entry-id');

                function updateCountdown() {
                    const timeLeft = calculateTimeDifference(createdAt, escalationTime);
                    element.innerText = timeLeft;
                    if (timeLeft === "00:00:00") {
                        clearInterval(interval); // Stop the interval once time is up
                        updateStatusToClosed(helpdeskId); // Update the status to closed
                    }
                }

                const interval = setInterval(updateCountdown, 1000);
                updateCountdown(); // Initial call to display countdown immediately
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            startCountdown();
        });
    </script>
@endsection
