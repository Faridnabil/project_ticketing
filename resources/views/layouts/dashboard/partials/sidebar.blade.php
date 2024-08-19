<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="#" class="logo">
                <img src="{{ asset('templates/assets/img/kaiadmin/logonew.png') }}" alt="navbar brand" class="navbar-brand"
                    height="80px" style="margin-top: 25px;" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner" style="margin-top: 15px">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                @can('View Dashboard Admin')
                    <li class="nav-item active">
                        <a class="menu-link {{ Request::is('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard.index') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan
                @can('View Dashboard User')
                    <li class="nav-item active">
                        <a class="menu-link {{ Request::is('user.dashboard') ? 'active' : '' }}"
                            href="{{ route('user.dashboard.index') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan
                @can('View Dashboard SysAdmin')
                    <li class="nav-item active">
                        <a class="menu-link {{ Request::is('sysadmin.dashboard') ? 'active' : '' }}"
                            href="{{ route('sysadmin.dashboard.index') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan
                @can('View Dashboard DBA')
                    <li class="nav-item active">
                        <a class="menu-link {{ Request::is('dba.dashboard') ? 'active' : '' }}"
                            href="{{ route('dba.dashboard.index') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan
                @can('View User Management')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                @elsecan('View Category')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                    @elsecan('View Service')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                @elsecan('View Priority')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                @elsecan('View Status')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                @endcan


                @can('View User Management')
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#userManagement">
                            <i class="fas fa-users"></i>
                            <p>Manage Pengguna</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="userManagement">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a class="menu-link" href="{{ route('user.index') }}">
                                        <span class="sub-item">Pengguna</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="menu-link" href="{{ route('role.index') }}">
                                        <span class="sub-item">Peran</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="menu-link" href="{{ route('permission.index') }}">
                                        <span class="sub-item">Izin Akses</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
                @endcan


                @can('View Category')
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#category">
                            <i class="fas fa-list"></i>
                            <p>Kategori</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="category">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a class="menu-link {{ Request::is('category') ? 'active' : '' }}"
                                        href="{{ route('category.index') }}">
                                        <span class="sub-item">Kategori Tiket</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="menu-link menu-link {{ Request::is('incidental-activity-category') ? 'active' : '' }}"
                                        href="{{ route('incidental-activity-category.index') }}">
                                        <span class="sub-item">Kategori Insidental</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('View Priority')
                    <li class="nav-item">
                        <a class="menu-link {{ Request::is('service') ? 'active' : '' }}"
                            href="{{ route('service.index') }}">
                            <i class="fas fa-cogs"></i>
                            <p>Layanan</p>
                        </a>
                    </li>
                @endcan

                @can('View Priority')
                    <li class="nav-item">
                        <a class="menu-link {{ Request::is('priority') ? 'active' : '' }}"
                            href="{{ route('priority.index') }}">
                            <i class="fas fa-layer-group"></i>
                            <p>Prioritas</p>
                        </a>
                    </li>
                @endcan

                @can('View Status')
                    <li class="nav-item">
                        <a class="menu-link {{ Request::is('status') ? 'active' : '' }}"
                            href="{{ route('status.index') }}">
                            <i class="fas fa-tasks"></i>
                            <p>Status</p>
                        </a>
                    </li>
                @endcan

                @can('View Ticket')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Aplikasi Tiket</h4>
                    </li>
                    @role('Admin')
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('ticket') ? 'active' : '' }}"
                                href="{{ route('ticket.index') }}">
                                <i class="fas fa-ticket-alt"></i>
                                <p>Semua Tiket</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('requestAssignment') ? 'active' : '' }}"
                                href="{{ route('requestAssignment.index') }}">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Daftar Pengajuan</p>
                            </a>
                        </li>
                    @endrole
                    @role('User')
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('myTicket') ? 'active' : '' }}"
                                href="{{ route('myTicket.index') }}">
                                <i class="fas fa-ticket-alt"></i>
                                <p>Tiket Saya</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('myTicket') ? 'active' : '' }}"
                                href="{{ route('myTicket.completed') }}">
                                <i class="fas fa-history"></i>
                                <p>Riwayat Tiket</p>
                            </a>
                        </li>
                    @endrole
                    @role('SysAdmin')
                        @php
                            $unassignedTicketsCount = app(
                                'App\Http\Controllers\Sysadmin\UnassignedSysadminController',
                            )->countUnassignedTickets();
                        @endphp

                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('unassignedSysadmin') ? 'active' : '' }}"
                                href="{{ route('unassignedSysadmin.index') }}">
                                <i class="fas fa-hourglass-start"></i>
                                <p>Belum Ditetapkan</p>
                                <span class="badge badge-secondary">{{ $unassignedTicketsCount }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('assignedSysadmin') ? 'active' : '' }}"
                                href="{{ route('assignedSysadmin.index') }}">
                                <i class="fas fa-spinner"></i>
                                <p>Tiket Proses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('assignedSysadmin') ? 'active' : '' }}"
                                href="{{ route('sysadmin.completed-tickets') }}">
                                <i class="fas fa-check-circle"></i>
                                <p>Tiket Selesai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link" href="{{ route('sysadmin.incidental-activities.index') }}">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Incidental Activity</p>
                            </a>
                        </li>
                    @endrole

                    @role('DBA')
                        @php
                            $unassignedTicketsCount = app(
                                'App\Http\Controllers\Sysadmin\UnassignedSysadminController',
                            )->countUnassignedTickets();
                        @endphp

                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('unassignedTicket') ? 'active' : '' }}"
                                href="{{ route('unassignedDba.index') }}">
                                <i class="fas fa-hourglass-start"></i>
                                <p>Belum Ditetapkan</p>
                                <span class="badge badge-secondary">{{ $unassignedTicketsCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('assignedTicket') ? 'active' : '' }}"
                                href="{{ route('assignedDba.index') }}">
                                <i class="fas fa-spinner"></i>
                                <p>Tiket Proses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('assignedTicket') ? 'active' : '' }}"
                                href="{{ route('dba.completed-tickets') }}">
                                <i class="fas fa-check-circle"></i>
                                <p>Tiket Selesai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link" href="{{ route('dba.incidental-activities.index') }}">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Incidental Activity</p>
                            </a>
                        </li>
                    @endrole
                @endcan
            </ul>
        </div>
    </div>
</div>
