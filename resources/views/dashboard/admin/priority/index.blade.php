@extends('layouts.dashboard.app')

@section('title')
    Prioritas | PLN Icon+
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Prioritas
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Prioritas</small>
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
                @can('Create Priority')
                    <div class="card-toolbar">
                        <!--begin::Add user-->
                        <a href="{{ route('priority.create') }}" class="btn btn-primary mb-4">
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
                            <!--end::Svg Icon-->Tambah Priority</a>
                        <!--end::Add user-->
                    </div>
                @endcan
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Prioritas</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Prioritas</th>
                                    <th style="width: 300px">Fitur</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Prioritas</th>
                                    <th style="width: 300px">Fitur</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if ($priorities->count())
                                    @foreach ($priorities as $priority)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($priority->priority_name == 'Critical')
                                                    <span class="badge"
                                                        style="background-color:red ; color: white; font-weight:bold">
                                                        Critical</span>
                                                @elseif($priority->priority_name == 'Medium')
                                                    <span class="badge"
                                                        style="background-color:blue ; color: white; font-weight:bold">
                                                        Medium</span>
                                                @elseif($priority->priority_name == 'High')
                                                    <span class="badge"
                                                        style="background-color:#FF7F3E ; color: white; font-weight:bold">
                                                        High</span>
                                                @elseif($priority->priority_name == 'Low')
                                                    <span class="badge"
                                                        style="background-color:green ; color: white; font-weight:bold">
                                                        Low</span>
                                                @else
                                                    {{ $priority->priority_name }}
                                                @endif
                                            </td>
                                            <td>
                                                @can('Edit Priority')
                                                    <a href="{{ route('priority.edit', $priority->id) }}"
                                                        class="btn btn-primary px-6 align-self-center text-nowrap">Ubah</a>
                                                @endcan
                                                @can('Delete Priority')
                                                    <button type="reset"
                                                        class="btn btn-danger px-6 align-self-center text-nowrap"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_priority_{{ $priority->id }}">Hapus</button>
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
        </div>
    </div>

    @foreach ($priorities as $priority)
        <div class="modal fade" tabindex="-1" id="kt_modal_priority_{{ $priority->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Hapus Prioritas
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <h5>Apakah Anda yakin menghapus Prioritas ini?</h5>
                                <small class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                <ul class="mt-3 mb-0">
                                    <li>{{ $priority->priority_name }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <form action="{{ route('priority.destroy', $priority->id) }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
    @endforeach

@endsection
