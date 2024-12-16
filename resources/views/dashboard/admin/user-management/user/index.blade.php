@extends('layouts.dashboard.app')

@section('title')
    Data Pengguna | Ticketing
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Pengguna
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Pengguna</small>
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
                        @can('Create User')
                            <div class="card-toolbar">
                                <!--begin::Add user-->
                                <a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-4">
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
                                    <!--end::Svg Icon-->Tambah Pengguna</a>
                                <!--end::Add user-->
                            </div>
                        @endcan
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table id="kt_datatable_example_5"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-70px">Pengguna</th>
                                    <th class="min-w-70px">NIK</th>
                                    <th class="min-w-70px">Role</th>
                                    <th class="min-w-70px">Jenis Kelamin</th>
                                    <th class="min-w-70px">Tanggal Bergabung</th>
                                    <th class="min-w-70px">Fitur</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-bold">
                                @if ($users->count())
                                    @foreach ($users as $user)
                                        <!--begin::Table row-->
                                        <tr class="fs-6 w-100">
                                            <td class="min-w-10px">{{ $loop->iteration }}</td>
                                            <!--begin::User=-->
                                            <td class="d-flex align-items-center">
                                                <!--begin:: Avatar -->
                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                    <a href="apps/user-management/users/view.html">
                                                        <div class="symbol-label">
                                                            <img src="{{ asset($user->photo ? $user->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                                                class="w-100" />
                                                        </div>
                                                    </a>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::User details-->
                                                <div class="d-flex flex-column">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary mb-1">{{ $user->name }}</a>
                                                    <span>{{ $user->email }}</span>
                                                </div>
                                                <!--begin::User details-->
                                            </td>
                                            <!--end::User=-->

                                            <!--begin::Nik=-->
                                            <td>
                                                {{ $user->nik }}
                                            </td>
                                            <!--end::Nik=-->

                                            <!--begin::Role=-->
                                            <td class="w-40 m-auto">
                                                @foreach ($user->getRoleNames() as $roles)
                                                    @if ($roles == 'Super Admin')
                                                        <a href="role" class="badge bg-primary w-40 p-3 mt-3">
                                                            {{ $roles }}
                                                        </a>
                                                    @elseif ($roles == 'Admin')
                                                        <a href="role" class="badge bg-success w-40 p-3 mt-3">
                                                            {{ $roles }}
                                                        </a>
                                                    @else
                                                        <a href="role" class="badge bg-danger w-40 p-3 mt-3">
                                                            {{ $roles }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <!--end::Role=-->

                                            @if ($user->gender)
                                                <td>
                                                    {{ $user->gender }}
                                                </td>
                                            @else
                                                <td>
                                                    <span class="badge mt-4"
                                                        style="background-color:rgb(77, 75, 75) ; color: white; font-weight:bold w-100 mt-3 p-3">
                                                        -
                                                    </span>
                                                </td>
                                            @endif

                                            <!--begin::Joined-->
                                            <td>{{ date('d F Y', strtotime($user->created_at)) }}</td>
                                            <!--begin::Joined-->
                                            <!--begin::Action=-->
                                            <td>
                                                @can('Edit User')
                                                    <a class="menu-link ms-3" href="{{ route('admin.user.edit', $user->id) }}"
                                                        type="button" title="Edit">
                                                        <span class="menu-icon" style="fill: #bd6710">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z" />
                                                                    <path
                                                                        d="M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('Delete User')
                                                    <a class="menu-link ms-3" href="#" type="reset" title="Hapus"
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_1{{ $user->id }}">
                                                        <span class="menu-icon" style="fill: #e21414">
                                                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <path
                                                                        d="M23,3H18V2.5A2.5,2.5,0,0,0,15.5,0h-7A2.5,2.5,0,0,0,6,2.5V3H1V6H3V21a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V6h2ZM18,21H6V6H18Z" />
                                                                    <rect x="8" y="9" width="3" height="9" />
                                                                    <rect x="13" y="9" width="3" height="9" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                @endcan
                                            </td>
                                            <!--end::Action=-->
                                        </tr>
                                        <!--end::Table row-->
                                    @endforeach
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
    @foreach ($users as $user)
        <div class="modal fade" tabindex="-1" id="kt_modal_1{{ $user->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Hapus Pengguna
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3 text-center align-self-center">
                                <img src="{{ asset($user->photo ? $user->photo : 'template/assets/images/users/user-1.png') }}"
                                    alt="" class="img-fluid">
                            </div><!--end col-->
                            <div class="col-lg-9">
                                <h5>Apakah Anda yakin menghapus pengguna ini?</h5>
                                <span class="badge bg-soft" style="color: black">
                                    Akses :
                                </span>
                                <small
                                    class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                <ul class="mt-3 mb-0">
                                    <li>{{ $user->name }}</li>
                                    <li>{{ $user->email }}</li>
                                    <li>
                                        {{ $user->email_verified_at ? 'Email Pengguna Sudah Verifikasi' : 'Email Pengguna Belum Verifikasi' }}
                                    </li>
                                </ul>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline">
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
