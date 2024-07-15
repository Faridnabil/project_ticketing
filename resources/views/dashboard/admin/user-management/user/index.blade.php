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
            <!--begin::Card-->

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
                        <a href="{{ route('user.create') }}" class="btn btn-primary mb-4">
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Pengguna</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengguna</th>
                                    <th>Peran</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Fitur</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Pengguna</th>
                                    <th>Peran</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Bergabung</th>
                                    <th style="width: 300px">Fitur</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if ($users->count())
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
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
                                                    @if ($roles == 'Super Admin')
                                                        <a href="role" class="badge bg-primary">
                                                            {{ $roles }}
                                                        </a>
                                                    @elseif ($roles == 'Admin')
                                                        <a href="role" class="badge bg-success">
                                                            {{ $roles }}
                                                        </a>
                                                    @else
                                                        <a href="role" class="badge bg-danger">
                                                            {{ $roles }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $user->gender }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                @can('Edit User')
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-primary px-6 align-self-center text-nowrap">Ubah</a>
                                                @endcan
                                                @can('Delete User')
                                                    <a href="£" class="btn btn-danger px-6 align-self-center text-nowrap"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_1{{ $user->id }}">Hapus</a>
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
