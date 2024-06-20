@extends('layouts.admin')

@section('content')
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
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Prioritas</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">

            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                title="Click to add a helpdesk">
                @can('helpdesk_create')
                    <a href="{{ route('admin.helpdesks.create') }}" class="btn btn-sm btn-light-primary">
                        <!--begin::Svg Icon | path: icons/duotone/Communication/Add-user.svg-->
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                version="1.1">
                                <path
                                    d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path
                                    d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                    fill="#000000" fill-rule="nonzero" />
                            </svg>
                        </span>
                        <!--end::Svg Icon--> {{ trans('global.add') }} {{ trans('cruds.helpdesk.title_singular') }}</a>
                @endcan
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="kt_datatable_example_5" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
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
                            <th>Action</th>
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
                                        background-color: #dc3545;
                                        /* Warna merah */
                                    }

                                    .btn-high {
                                        background-color: #007bff;
                                        /* Warna biru */
                                    }

                                    .btn-medium {
                                        background-color: #ffc107;
                                        /* Warna kuning */
                                    }

                                    .btn-low {
                                        background-color: #FFA500;
                                        /* Warna hijau */
                                    }

                                    .btn-low-lvl1 {
                                        background-color: #28A7A7;
                                        /* Warna hijau */
                                        /* color: black;  */
                                    }
                                </style>

                                <td>
                                    @if ($helpdesk->priority->name == 'Critical / Level 2')
                                        <button
                                            class="btn-custom btn-critical">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @elseif($helpdesk->priority->name == 'High / Level 2')
                                        <button class="btn-custom btn-high">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @elseif($helpdesk->priority->name == 'Medium / Level 2')
                                        <button
                                            class="btn-custom btn-medium">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @elseif($helpdesk->priority->name == 'Low / Level 2')
                                        <button class="btn-custom btn-low">{{ $helpdesk->priority->name ?? '' }}</button>
                                    @elseif($helpdesk->priority->name == 'Low / Level 1')
                                        <button
                                            class="btn-custom btn-low-lvl1">{{ $helpdesk->priority->name ?? '' }}</button>
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
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
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
