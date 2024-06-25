@extends('layouts.dashboard.app')

@section('title')
    Data Izin | SIAK Ducapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Izin
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Izin</small>
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
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add user-->
                            <a href="{{ route('permission.create') }}" class="btn btn-primary mb-4">
                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                        <rect fill="#000000" opacity="0.5"
                                            transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)"
                                            x="4" y="11" width="16" height="2" rx="1" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Tambah Izin</a>
                            <!--end::Add user-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <table id="kt_datatable_example_5" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-10px">Izin</th>
                                    <th class="min-w-125px">Peran</th>
                                    <th class="min-w-125px">Tanggal Dibuat</th>
                                    <th class="text-end min-w-100px">Fitur</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-bold">
                                @if ($permissions->count())
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                @foreach ($permission->getRoleNames() as $roles)
                                                    @if ($roles == 'Super Admin')
                                                        <a href="role" class="badge bg-primary">{{ $roles }}</a>
                                                    @elseif ($roles == 'Admin')
                                                        <a href="role" class="badge bg-success">{{ $roles }}</a>
                                                    @elseif ($roles == 'Manager')
                                                        <a href="role" class="badge bg-warning">{{ $roles }}</a>
                                                    @elseif ($roles == 'Vendor')
                                                        <a href="role" class="badge bg-info">{{ $roles }}</a>
                                                    @else
                                                        <a href="role" class="badge bg-danger">{{ $roles }}</a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ date('d F Y', strtotime($permission->created_at)) }}</td>
                                            <td>
                                                @can('Edit Permission')
                                                <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-primary px-6 align-self-center text-nowrap">Ubah</a>
                                                @endcan
                                                @can('Delete Permission')
                                                    <button type="reset" class="btn btn-danger px-6 align-self-center text-nowrap" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_1{{ $permission->id }}">Hapus</button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Post-->
    @foreach ($permissions as $permission)
    <div class="modal fade" tabindex="-1" id="kt_modal_1{{ $permission->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">Form Hapus Izin</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <h5>Apakah Anda yakin menghapus Izin ini?</h5>
                            <span class="badge bg-soft" style="color: black">Akses :</span>
                            <small class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                            <ul class="mt-3 mb-0">
                                <li>{{ $permission->name }}</li>
                            </ul>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div><!--end modal-footer-->
            </div>
        </div>
    </div>
@endforeach


@endsection
