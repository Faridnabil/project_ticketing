<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="#" class="logo">
                <img src="{{ asset('templates/assets/img/kaiadmin/logonew.png') }}" alt="navbar brand" class="navbar-brand"
                    height="80px" style="margin-top: 25px;"/>
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
                @can('View Dashboard Customer')
                    <li class="nav-item active">
                        <a class="menu-link {{ Request::is('customer.dashboard') ? 'active' : '' }}"
                            href="{{ route('customer.dashboard.index') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan
                @can('View Dashboard Department')
                    <li class="nav-item active">
                        <a class="menu-link {{ Request::is('department.dashboard') ? 'active' : '' }}"
                            href="{{ route('department.dashboard.index') }}" aria-expanded="false">
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
                        <a data-bs-toggle="collapse" href="#base">
                            <i class="fas fa-users"></i>
                            <p>Manage Pengguna</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="base">
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
                                <li>
                                    <a class="menu-link" href="{{ route('permission.index') }}">
                                        <span class="sub-item">Izin Akses</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('View Category')
                    <li class="nav-item">
                        <a class="menu-link {{ Request::is('category') ? 'active' : '' }}"
                            href="{{ route('category.index') }}">
                            <i class="fas fa-th-list"></i>
                            <p>Kategori</p>
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
                    @role('Customer')
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
                    @role('Tenaga Ahli')
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('unassignedTicket') ? 'active' : '' }}"
                                href="{{ route('unassignedTicket.index') }}">
                                <i class="fas fa-hourglass-start"></i>
                                <p>Belum Ditetapkan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('assignedTicket') ? 'active' : '' }}"
                                href="{{ route('assignedTicket.index') }}">
                                <i class="fas fa-spinner"></i>
                                <p>Tiket Proses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="menu-link {{ Request::is('assignedTicket') ? 'active' : '' }}"
                                href="{{ route('department.completed-tickets') }}">
                                <i class="fas fa-check-circle"></i>
                                <p>Tiket Selesai</p>
                            </a>
                        </li>
                    @endrole
                @endcan
            </ul>
        </div>
    </div>
</div>
