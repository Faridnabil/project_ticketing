@extends('layouts.dashboard.app')

@section('title')
    Prioritas | SIAK Dukcapil
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
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-10px">No</th>
                                <th class="min-w-125px">Pengguna</th>
                                <th class="min-w-125px">Peran</th>
                                <th class="min-w-125px">Jenis Kelamin</th>
                                <th class="min-w-125px">Tanggal Bergabung</th>
                                <th class="text-end min-w-100px">Fitur</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @if ($users->count())
                                @foreach ($users as $user)
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="min-w-10px">{{ $loop->iteration }}</td>
                                        <!--begin::User=-->
                                        <td class="d-flex align-items-center">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="apps/user-management/users/view.html">
                                                    <div class="symbol-label">
                                                        @if ($user->gender == 'Pria')
                                                            <img src="{{ asset($user->photo ? $user->photo : 'template/assets/images/users/user-12.jpg') }}"
                                                                class="w-100" />
                                                        @else
                                                            <img src="{{ asset($user->photo ? $user->photo : 'template/assets/images/users/user-12.jpg') }}"
                                                                class="w-100" />
                                                        @endif
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
                                        <!--begin::Role=-->
                                        <td>
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
                                        <!--end::Role=-->

                                        <td>
                                            {{ $user->gender }}
                                        </td>

                                        <!--begin::Joined-->
                                        <td>{{ $user->created_at }}</td>
                                        <!--begin::Joined-->
                                        <!--begin::Action=-->
                                        <td class="text-end">
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                data-kt-menu-flip="top-end">Aksi
                                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <path
                                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                                fill="#000000" fill-rule="nonzero"
                                                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon--></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="menu-link px-3">Ubah</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_1{{ $user->id }}">Hapus</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
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
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Modals-->
            @foreach ($users as $user)
                <div class="modal fade" tabindex="-1" id="kt_modal_1{{ $user->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">
                                    Form Hapus Pengguna
                                </h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
                                    Close
                                </button>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Submit</button>
                                </form>
                            </div><!--end modal-footer-->
                        </div>
                    </div>
                </div>
            @endforeach
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
