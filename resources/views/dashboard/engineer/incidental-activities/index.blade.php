@extends('layouts.dashboard.app')

@section('title')
    Dashboard | PLN Icon+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Semua Incidental Activities</h4>
                    <div class="d-flex align-items-center">
                        {{-- <a href="{{ route('dba.incidental-activities.create') }}" class="btn btn-primary btn-sm">
                            <span class="btn-label">
                                <i class="fas fa-plus"></i>
                            </span>
                            Tambah Activity
                        </a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Executor</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $activity->title }}</td>
                                        <td>{{ $activity->category->category_name }}</td>
                                        <td>{{ $activity->executor }}</td>
                                        <td>{{ $activity->sysdba }}</td>
                                        <td>
                                            @if ($activity->status_id == '1')
                                                <span class="badge"
                                                    style="background-color:red; color: white; font-weight:bold">Tertunda</span>
                                            @elseif($activity->status_id == '2')
                                                <span class="badge"
                                                    style="background-color:blue; color: white; font-weight:bold">Diterima</span>
                                            @elseif($activity->status_id == '3')
                                                <span class="badge"
                                                    style="background-color:#FF7F3E; color: white; font-weight:bold">Proses</span>
                                            @elseif($activity->status_id == '4')
                                                <span class="badge"
                                                    style="background-color:green; color: white; font-weight:bold">Selesai</span>
                                            @else
                                                <span class="badge"
                                                    style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                            @endif
                                        </td>
                                        {{-- <td class="text-center">
                                            <a href="{{ route('dba.incidental-activities.edit', $activity->id) }}"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
                                            <button type="button"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_activity_{{ $activity->id }}">
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
                                            </button>
                                        </td> --}}
                                    </tr>
                                    <!-- Modal -->
                                {{-- <div class="modal fade" id="kt_modal_activity_{{ $activity->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title text-white">Hapus Incidental Activity</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus activity ini?</p>
                                                <ul>
                                                    <li>{{ $activity->title }}</li>
                                                    <li>{{ $activity->category }}</li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <form
                                                    action="{{ route('dba.incidental-activities.destroy', $activity->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
