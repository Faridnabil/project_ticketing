@extends('layouts.dashboard.app')

@section('title')
    Status | PLN Icon+
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Status
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Status</small>
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
        <div id="kt_content_container" class="container">
            <!--begin::Card-->
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                @can('Create Status')
                    <div class="card-toolbar">
                        <!--begin::Add user-->
                        <a href="{{ route('status.create') }}" class="btn btn-primary mb-4">
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
                            <!--end::Svg Icon-->Tambah Status</a>
                        <!--end::Add user-->
                    </div>
                @endcan
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Status</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th style="width: 300px">Fitur</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th style="width: 300px">Fitur</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if ($statuses->count())
                                    @foreach ($statuses as $status)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($status->status_name == 'Tertunda')
                                                    <span class="badge"
                                                        style="background-color:red ; color: white; font-weight:bold">
                                                        Tertunda</span>
                                                @elseif($status->status_name == 'Diterima')
                                                    <span class="badge"
                                                        style="background-color:blue ; color: white; font-weight:bold">
                                                        Diterima</span>
                                                @elseif($status->status_name == 'Proses')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                        Proses</span>
                                                @elseif($status->status_name == 'Selesai')
                                                    <span class="badge"
                                                        style="background-color:green ; color: white; font-weight:bold">
                                                        Selesai</span>
                                                @else
                                                    {{ $status->status_name }}
                                                @endif
                                            </td>
                                            <td>
                                                @can('Edit Status')
                                                    <a href="{{ route('status.edit', $status->id) }}"
                                                        class="btn btn-primary px-6 align-self-center text-nowrap">Ubah</a>
                                                @endcan
                                                @can('Delete Status')
                                                    <button type="reset"
                                                        class="btn btn-danger px-6 align-self-center text-nowrap"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_status_{{ $status->id }}">Hapus</button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card toolbar-->
            <!--end::Card header-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->

    @foreach ($statuses as $status)
        <div class="modal fade" tabindex="-1" id="kt_modal_status_{{ $status->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Hapus Status
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <h5>Apakah Anda yakin menghapus Status ini?</h5>
                                <small class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                <ul class="mt-3 mb-0">
                                    <li>{{ $status->status_name }}</li>
                                </ul>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <form action="{{ route('status.destroy', $status->id) }}" method="POST" class="d-inline">
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
