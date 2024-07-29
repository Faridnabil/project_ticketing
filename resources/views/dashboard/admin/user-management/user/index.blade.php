@extends('layouts.dashboard.app')

@section('title')
    Data Pengguna | PLN Icon+
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
        <div id="kt_content_container" class="container">
            <div class="card">
                <div class="card-header card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Tabel Pengguna</h4>
                    <div class="d-flex align-items-center">
                        @can('Create User')
                            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm me-2">
                                <span class="btn-label">
                                    <i class="fas fa-plus"></i>
                                </span>
                                Tambah Pengguna
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Pengguna</th>
                                    <th class="text-center">Peran</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Tanggal Bergabung</th>
                                    <th class="text-center">Fitur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count())
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                        <a href="apps/user-management/users/view.html">
                                                            <div class="avatar-sm">
                                                                @if ($user->gender == 'Pria')
                                                                    <img src="{{ asset($user->photo ? $user->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                                                        class="avatar-img rounded-circle" />
                                                                @else
                                                                    <img src="{{ asset($user->photo ? $user->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                                                        class="avatar-img rounded-circle" />
                                                                @endif
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1">{{ $user->name }}</a>
                                                        <span>{{ $user->email }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="text-center">
                                                @foreach ($user->getRoleNames() as $roles)
                                                    @if ($roles == 'Admin')
                                                        <a href="role" class="badge bg-primary">
                                                            {{ $roles }}
                                                        </a>
                                                    @elseif ($roles == 'Tenaga Ahli')
                                                        <a href="role" class="badge bg-success">
                                                            {{ $roles }}
                                                        </a>
                                                    @else
                                                        <a href="role" class="badge bg-warning">
                                                            {{ $roles }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="text-center">{{ $user->gender }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td style="width: 100px">
                                                @can('Edit User')
                                                <a class="menu-link ms-3" href="{{ route('user.edit', $user->id) }}"
                                                    type="button">
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
                                                <a class="menu-link ms-3" href="#" type="reset"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_1{{ $user->id }}">
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
    @foreach ($users as $user)
        <div class="modal fade" tabindex="-1" id="kt_modal_1{{ $user->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                            Form Hapus Pengguna
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3 text-center align-self-center">
                                <img src="{{ asset($user->photo ? $user->photo : 'template/assets/images/users/user-1.png') }}"
                                    alt="" class="img-fluid">
                            </div>
                            <div class="col-lg-9">
                                <h5>Apakah Anda yakin menghapus pengguna ini?</h5>
                                <span class="badge bg-soft" style="color: black">
                                    Akses :
                                </span>
                                <small class="text-muted ml-2">{{ date('d F Y', strtotime(Carbon\Carbon::now())) }}</small>
                                <ul class="mt-3 mb-0">
                                    <li>{{ $user->name }}</li>
                                    <li>{{ $user->email }}</li>
                                    <li>
                                        {{ $user->email_verified_at ? 'Email Pengguna Sudah Verifikasi' : 'Email Pengguna Belum Verifikasi' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
