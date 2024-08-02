@extends('layouts.dashboard.app')

@section('title')
    Dashboard | PLN Icon+
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Dashboard
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Incidental Activities</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <!--begin::Row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-stretch">
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bolder mb-2 text-dark">Incidental Activities</span>
                                <span class="text-muted fw-bold fs-7">Manage your incidental activities</span>
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{ route('department.incidental-activities.create') }}" class="btn btn-primary">
                                    Add Activity
                                </a>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            {{-- <th class="w-25px">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-13-check" />
                                                </div>
                                            </th> --}}
                                            <th class="min-w-150px">No</th>
                                            <th class="min-w-150px">Title</th>
                                            {{-- <th class="min-w-150px">Description</th> --}}
                                            <th class="min-w-100px">Category</th>
                                            {{-- <th class="min-w-140px">Start Time</th>
                                            <th class="min-w-140px">End Time</th> --}}
                                            <th class="min-w-150px">Executor</th>
                                            <th class="min-w-150px">Department</th>
                                            {{-- <th class="min-w-150px">Mitigation</th>
                                            <th class="min-w-150px">Impact</th> --}}
                                            <th class="min-w-100px">Status</th>
                                            <th class="min-w-100px text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activities as $activity)
                                            <tr>
                                                {{-- <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input widget-13-check" type="checkbox" value="{{ $activity->id }}" />
                                                    </div>
                                                </td> --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $activity->title }}</td>
                                                {{-- <td>{{ $activity->description }}</td> --}}
                                                <td>{{ $activity->category }}</td>
                                                {{-- <td>{{ $activity->start_time }}</td>
                                                <td>{{ $activity->end_time }}</td> --}}
                                                <td>{{ $activity->executor }}</td>
                                                <td>{{ $activity->department }}</td>
                                                {{-- <td>{{ $activity->mitigation }}</td>
                                                <td>{{ $activity->impact }}</td> --}}
                                                <td>{{ $activity->status }}</td>
                                                <td class="text-end">
                                                    {{-- <a href="{{ route('department.incidental-activities.edit', $activity->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('department.incidental-activities.destroy', $activity->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
