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
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Kategori</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>

    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            {{-- <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1"> <a href=" admin/users/export"
                    class="btn btn-primary btn-md mr-1">Export Excel</a>
                <a href="admin/users/cetak_pdf" class="btn btn-primary" btn-md target="_blank">Export PDF</a>
            </span>
        </h3> --}}
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                title="Click to add a category">
                @can('ticket_create')
                    <a href="{{ route('admin.tickets.create') }}" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_invite_friends">
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
                        <!--end::Svg Icon--> {{ trans('global.add') }} {{ trans('cruds.ticket.title_singular') }}
                    </a>
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
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.ticket_id') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.title') }}
                            </th>
                            {{-- <th>
                                {{ trans('cruds.ticket.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.priority') }}
                            </th> --}}
                            <th>
                                {{ trans('cruds.ticket.fields.category') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.author_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.author_email') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.assigned_to_user') }}
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
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
        $(function() {
            let filters = `
            <form class="form-inline" id="filtersForm">
                <div class="form-group mx-sm-3 mb-2">
                    <select class="form-control" name="status">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}"{{ request('status') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select class="form-control" name="priority">
                    <option value="">All priorities</option>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->id }}"{{ request('priority') == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select class="form-control" name="category">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"{{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                    </select>
                </div>
            </form>`;
            $('.card-body').on('change', 'select', function() {
                $('#filtersForm').submit();
            })
            let dtButtons = []
            @can('ticket_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.tickets.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id
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
            let searchParams = new URLSearchParams(window.location.search)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: {
                    url: "{{ route('admin.tickets.index') }}",
                    data: {
                        'status': searchParams.get('status'),
                        'priority': searchParams.get('priority'),
                        'category': searchParams.get('category')
                    }
                },
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'ticket_id',
                        name: 'ticket_id',
                        render: function(data, type, row) {
                            return '<strong>' + data + '</strong>';
                        }
                    },

                    {
                        data: 'title',
                        name: 'title',
                        render: function(data, type, row) {
                            return '<a href="' + row.view_link +
                                '" style="text-decoration: underline;">' + data + ' (' + row
                                .comments_count + ')</a>';
                        }
                    },

                    // {
                    //   data: 'status_name',
                    //   name: 'status.name',
                    //   render: function ( data, type, row) {
                    //       if (data == 'On Progress') {
                    //           return '<button class="btn btn-primary">'+data+'</button>';
                    //       } else if (data == 'Open') {
                    //           return '<button class="btn btn-success">'+data+'</button>';
                    //       } else if (data == 'Closed') {
                    //           return '<button class="btn btn-danger">'+data+'</button>';
                    //       } else {
                    //           return data;
                    //       }
                    //   }
                    // },
                    // {
                    //   data: 'priority_name',
                    //   name: 'priority.name',
                    //   render: function ( data, type, row) {
                    //       if (data == 'Critical') {
                    //           return '<button class="btn btn-danger">'+data+'</button>';
                    //       } else if (data == 'High') {
                    //           return '<button class="btn btn-primary">'+data+'</button>';
                    //       } else if (data == 'Medium') {
                    //           return '<button class="btn btn-warning">'+data+'</button>';
                    //       } else if (data == 'Low') {
                    //           return '<button class="btn btn-warning">'+data+'</button>';
                    //       } else {
                    //           return data;
                    //       }
                    //   }
                    // },
                    {
                        data: 'category_name',
                        name: 'category.name',
                        render: function(data, type, row) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    {
                        data: 'author_name',
                        name: 'author_name'
                    },
                    {
                        data: 'author_email',
                        name: 'author_email'
                    },
                    {
                        data: 'assigned_to_user_name',
                        name: 'assigned_to_user.name'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            };
            $(".datatable-Ticket").one("preInit.dt", function() {
                $(".dataTables_filter").after(filters);
            });
            $('.datatable-Ticket').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
    </script>
@endsection
