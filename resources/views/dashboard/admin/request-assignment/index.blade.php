@extends('layouts.dashboard.app')

@section('title')
    Daftar Pengajuan | PLN Icon+
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Daftar Pengajuan
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Pengajuan Menangani Tiket</small>
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
            <!--begin::Card-->

            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                </div>
                <!--begin::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Pemohon</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Pemohon</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if ($requestAssignments->count())
                                    @foreach ($requestAssignments as $requestAssignment)
                                        <tr>
                                            <td>{{ $requestAssignment->ticket->no_ticket }}</td>
                                            <td>{{ $requestAssignment->ticket->title }}</td>
                                            <td>{{ $requestAssignment->user->name }}</td>
                                            <td>{{ date('d F Y', strtotime($requestAssignment->created_at)) }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('ticket.approveAssignment', $requestAssignment->id) }}"
                                                    method="POST" class="d-inline"
                                                    id="approve-form-{{ $requestAssignment->id }}">
                                                    @csrf
                                                    <a href="#" class="menu-link ms-3"
                                                        onclick="event.preventDefault(); document.getElementById('approve-form-{{ $requestAssignment->id }}').submit();">
                                                        <span class="menu-icon" style="fill: #0d8987">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="m21,11.706c1.153-.343,2.18-.974,3-1.812v14.106H0V6.5c0-1.93,1.57-3.5,3.5-3.5h8.794c-.189.634-.294,1.305-.294,2,0,.34.033.673.08,1H3.5c-.276,0-.5.225-.5.5v.383l7.374,7.446c.861.861,2.386.866,3.258-.005l2.812-2.812c.793.311,1.653.488,2.556.488.454,0,.897-.047,1.328-.13l-4.575,4.575c-1.003,1.003-2.336,1.555-3.753,1.555s-2.75-.552-3.753-1.555l-5.247-5.299v9.853h18v-9.294Zm-7-6.706c0-2.761,2.239-5,5-5s5,2.239,5,5-2.239,5-5,5-5-2.239-5-5Zm4,.414l2.293,2.293,1.414-1.414-1.707-1.707v-2.586h-2v3.414Z" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
