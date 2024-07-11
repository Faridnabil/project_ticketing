<div class="aside-menu flex-column-fluid">
    <!--begin::Aside Menu-->
    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
        data-kt-scroll-offset="0">
        <!--begin::Menu-->
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
            id="#kt_aside_menu" data-kt-menu="true">
            @can('View Dashboard Admin')
                <div class="menu-item">
                    <a class="menu-link {{ Request::is('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M14,10c0,1.019-.308,1.964-.832,2.754l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899Zm-6-4.899c-2.282,.463-4,2.48-4,4.899,0,2.761,2.239,5,5,5,1.019,0,1.964-.308,2.754-.832l-3.754-3.754V5.101Zm8,1.899h4v-2h-4v2Zm0,4h4v-2h-4v2Zm0,4h4v-2h-4v2Zm-3,4v2h5v2H6v-2h5v-2H0V4C0,2.346,1.346,1,3,1H21c1.654,0,3,1.346,3,3v15H13Zm-11-2H22V4c0-.551-.448-1-1-1H3c-.552,0-1,.449-1,1v13Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M14,10c0,1.019-.308,1.964-.832,2.754l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899Zm-6-4.899c-2.282,.463-4,2.48-4,4.899,0,2.761,2.239,5,5,5,1.019,0,1.964-.308,2.754-.832l-3.754-3.754V5.101Zm8,1.899h4v-2h-4v2Zm0,4h4v-2h-4v2Zm0,4h4v-2h-4v2Zm-3,4v2h5v2H6v-2h5v-2H0V4C0,2.346,1.346,1,3,1H21c1.654,0,3,1.346,3,3v15H13Zm-11-2H22V4c0-.551-.448-1-1-1H3c-.552,0-1,.449-1,1v13Z"
                                        fill="#000000" />
                                </svg>
                            </span>

                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title" style="color: white">Dashboard</span>
                    </a>
                </div>
            @endcan
            @can('View Dashboard Customer')
                <div class="menu-item">
                    <a class="menu-link {{ Request::is('customer.dashboard') ? 'active' : '' }}"
                        href="{{ route('customer.dashboard.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M14,10c0,1.019-.308,1.964-.832,2.754l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899Zm-6-4.899c-2.282,.463-4,2.48-4,4.899,0,2.761,2.239,5,5,5,1.019,0,1.964-.308,2.754-.832l-3.754-3.754V5.101Zm8,1.899h4v-2h-4v2Zm0,4h4v-2h-4v2Zm0,4h4v-2h-4v2Zm-3,4v2h5v2H6v-2h5v-2H0V4C0,2.346,1.346,1,3,1H21c1.654,0,3,1.346,3,3v15H13Zm-11-2H22V4c0-.551-.448-1-1-1H3c-.552,0-1,.449-1,1v13Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M14,10c0,1.019-.308,1.964-.832,2.754l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899Zm-6-4.899c-2.282,.463-4,2.48-4,4.899,0,2.761,2.239,5,5,5,1.019,0,1.964-.308,2.754-.832l-3.754-3.754V5.101Zm8,1.899h4v-2h-4v2Zm0,4h4v-2h-4v2Zm0,4h4v-2h-4v2Zm-3,4v2h5v2H6v-2h5v-2H0V4C0,2.346,1.346,1,3,1H21c1.654,0,3,1.346,3,3v15H13Zm-11-2H22V4c0-.551-.448-1-1-1H3c-.552,0-1,.449-1,1v13Z"
                                        fill="#000000" />
                                </svg>
                            </span>

                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
            @endcan
            @can('View Dashboard Department')
                <div class="menu-item">
                    <a class="menu-link {{ Request::is('department.dashboard') ? 'active' : '' }}"
                        href="{{ route('department.dashboard.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M14,10c0,1.019-.308,1.964-.832,2.754l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899Zm-6-4.899c-2.282,.463-4,2.48-4,4.899,0,2.761,2.239,5,5,5,1.019,0,1.964-.308,2.754-.832l-3.754-3.754V5.101Zm8,1.899h4v-2h-4v2Zm0,4h4v-2h-4v2Zm0,4h4v-2h-4v2Zm-3,4v2h5v2H6v-2h5v-2H0V4C0,2.346,1.346,1,3,1H21c1.654,0,3,1.346,3,3v15H13Zm-11-2H22V4c0-.551-.448-1-1-1H3c-.552,0-1,.449-1,1v13Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M14,10c0,1.019-.308,1.964-.832,2.754l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899Zm-6-4.899c-2.282,.463-4,2.48-4,4.899,0,2.761,2.239,5,5,5,1.019,0,1.964-.308,2.754-.832l-3.754-3.754V5.101Zm8,1.899h4v-2h-4v2Zm0,4h4v-2h-4v2Zm0,4h4v-2h-4v2Zm-3,4v2h5v2H6v-2h5v-2H0V4C0,2.346,1.346,1,3,1H21c1.654,0,3,1.346,3,3v15H13Zm-11-2H22V4c0-.551-.448-1-1-1H3c-.552,0-1,.449-1,1v13Z"
                                        fill="#000000" />
                                </svg>
                            </span>

                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
            @endcan
            @can('View User Management')
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master Data</span>
                    </div>
                </div>
            @elsecan('View Category')
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master Data</span>
                    </div>
                </div>
            @elsecan('View Priority')
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master Data</span>
                    </div>
                </div>
            @elsecan('View Status')
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master Data</span>
                    </div>
                </div>
            @endcan

            @can('View User Management')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24" />
                                        <path
                                            d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path
                                            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                            fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Manajemen Pengguna</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('user.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pengguna</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('role.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Peran</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('permission.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Ijin Akses</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

            @can('View Category')
                <div class="menu-item">
                    <a class="menu-link {{ Request::is('category') ? 'active' : '' }}"
                        href="{{ route('category.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                    viewBox="0 0 24 24" version="1.1">
                                    <path
                                        d="m21,0H3C1.346,0,0,1.346,0,3v21h24V3c0-1.654-1.346-3-3-3Zm1,22H2V3c0-.551.448-1,1-1h18c.552,0,1,.449,1,1v19ZM4,11h7v-7h-7v7Zm2-5h3v3h-3v-3Zm7,5h7v-7h-7v7Zm2-5h3v3h-3v-3Zm-11,14h7v-7h-7v7Zm2-5h3v3h-3v-3Zm7,5h7v-7h-7v7Zm2-5h3v3h-3v-3Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="m21,0H3C1.346,0,0,1.346,0,3v21h24V3c0-1.654-1.346-3-3-3Zm1,22H2V3c0-.551.448-1,1-1h18c.552,0,1,.449,1,1v19ZM4,11h7v-7h-7v7Zm2-5h3v3h-3v-3Zm7,5h7v-7h-7v7Zm2-5h3v3h-3v-3Zm-11,14h7v-7h-7v7Zm2-5h3v3h-3v-3Zm7,5h7v-7h-7v7Zm2-5h3v3h-3v-3Z"
                                        fill="#000000" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Kategori</span>
                    </a>
                </div>
            @endcan
            @can('View Priority')
                <div class="menu-item">
                    <a class="menu-link {{ Request::is('priority') ? 'active' : '' }}"
                        href="{{ route('priority.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                    viewBox="0 0 24 24" version="1.1">
                                    <path
                                        d="m24,2v2H8v-2h16Zm-11,9h-5v2h5v-2ZM0,0h6v6.004H0V0Zm2,4.004h2v-2.004h-2v2.004ZM0,9h6v6.004H0v-6.004Zm2,4.004h2v-2.004h-2v2.004Zm6,8.996h7v-2h-7v2ZM0,18h6v6.004H0v-6.004Zm2,4.004h2v-2.004h-2v2.004Zm15.586-15.418l-3.579,3.58,1.414,1.414,2.579-2.579v15h2v-15l2.564,2.564,1.414-1.414-3.564-3.565c-.779-.778-2.049-.779-2.828,0Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="m24,2v2H8v-2h16Zm-11,9h-5v2h5v-2ZM0,0h6v6.004H0V0Zm2,4.004h2v-2.004h-2v2.004ZM0,9h6v6.004H0v-6.004Zm2,4.004h2v-2.004h-2v2.004Zm6,8.996h7v-2h-7v2ZM0,18h6v6.004H0v-6.004Zm2,4.004h2v-2.004h-2v2.004Zm15.586-15.418l-3.579,3.58,1.414,1.414,2.579-2.579v15h2v-15l2.564,2.564,1.414-1.414-3.564-3.565c-.779-.778-2.049-.779-2.828,0Z"
                                        fill="#000000" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Prioritas</span>
                    </a>
                </div>
            @endcan
            @can('View Status')
                <div class="menu-item">
                    <a class="menu-link {{ Request::is('status') ? 'active' : '' }}" href="{{ route('status.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Interface/Doughnut.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11 4.25769C11 3.07501 9.9663 2.13515 8.84397 2.50814C4.86766 3.82961 2 7.57987 2 11.9999C2 13.6101 2.38057 15.1314 3.05667 16.4788C3.58731 17.5363 4.98303 17.6028 5.81966 16.7662L5.91302 16.6728C6.60358 15.9823 6.65613 14.9011 6.3341 13.9791C6.11766 13.3594 6 12.6934 6 11.9999C6 9.62064 7.38488 7.56483 9.39252 6.59458C10.2721 6.16952 11 5.36732 11 4.39046V4.25769ZM16.4787 20.9434C17.5362 20.4127 17.6027 19.017 16.7661 18.1804L16.6727 18.087C15.9822 17.3964 14.901 17.3439 13.979 17.6659C13.3594 17.8823 12.6934 17.9999 12 17.9999C11.3066 17.9999 10.6406 17.8823 10.021 17.6659C9.09899 17.3439 8.01784 17.3964 7.3273 18.087L7.23392 18.1804C6.39728 19.017 6.4638 20.4127 7.52133 20.9434C8.86866 21.6194 10.3899 21.9999 12 21.9999C13.6101 21.9999 15.1313 21.6194 16.4787 20.9434Z"
                                        fill="#12131A" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13 4.39046C13 5.36732 13.7279 6.16952 14.6075 6.59458C16.6151 7.56483 18 9.62064 18 11.9999C18 12.6934 17.8823 13.3594 17.6659 13.9791C17.3439 14.9011 17.3964 15.9823 18.087 16.6728L18.1803 16.7662C19.017 17.6028 20.4127 17.5363 20.9433 16.4788C21.6194 15.1314 22 13.6101 22 11.9999C22 7.57987 19.1323 3.82961 15.156 2.50814C14.0337 2.13515 13 3.07501 13 4.25769V4.39046Z"
                                        fill="#12131A" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Status</span>
                    </a>
                </div>
            @endcan
            @can('View Attendance')
                <div class="menu-item">
                    <a class="menu-link {{ Request::is('attendance') ? 'active' : '' }}"
                        href="{{ route('attendance.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Interface/Doughnut.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
                                viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M19.732,13.732l-6.732,6.732v3.536h3.536l6.732-6.732c.472-.472,.732-1.1,.732-1.768s-.26-1.296-.732-1.768c-.943-.944-2.592-.944-3.535,0Zm2.828,2.828l-6.439,6.439h-2.122v-2.122l6.439-6.439c.566-.566,1.555-.566,2.121,0,.283,.283,.439,.66,.439,1.061s-.156,.777-.439,1.061Zm-5.924-2.561H5v-1h12.637l-1,1ZM21.5,2h-3.5V0h-1V2H7V0h-1V2H2.5C1.122,2,0,3.122,0,4.5V24H11v-1H1V9H23v2.294c.352,.122,.692,.27,1,.472V4.5c0-1.378-1.122-2.5-2.5-2.5ZM1,8v-3.5c0-.827,.673-1.5,1.5-1.5H21.5c.827,0,1.5,.673,1.5,1.5v3.5H1Zm4,10h7.636l-1,1H5v-1Z" />
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Absensi</span>
                    </a>
                </div>
            @endcan

            @can('View Ticket')
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Aplikasi Tiket</span>
                    </div>
                </div>
                @role('Admin')

                <div class="menu-item">
                    <a class="menu-link {{ Request::is('attendance') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                    viewBox="0 0 24 24" version="1.1">
                                    <path
                                        d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                        fill="#000000" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Absen</span>
                    </a>
                </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::is('ticket') ? 'active' : '' }}" href="{{ route('ticket.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                            fill="#000000" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Semua Tiket</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::is('requestAssignment') ? 'active' : '' }}"
                            href="{{ route('requestAssignment.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="m11,10v1c0,.552-.448,1-1,1h-5c-.552,0-1-.448-1-1v-1c0-.552.448-1,1-1h5c.552,0,1,.448,1,1Zm13-3.5v10.5c0,.357-.19.688-.5.866-.309.178-.69.178-.999,0l-2.17-1.25-1.767,1.209c-.172.118-.369.175-.563.175-.319,0-.633-.152-.826-.436-.312-.455-.195-1.077.261-1.39l2.285-1.564c.315-.217.731-.234,1.063-.041l1.216.7V6.5c0-2.481-2.019-4.5-4.5-4.5-2.249,0-4.097,1.624-4.431,3.815,1.164.814,1.931,2.16,1.931,3.685v10c0,2.481-2.019,4.5-4.5,4.5h-6c-2.481,0-4.5-2.019-4.5-4.5v-10c0-1.557.795-2.93,2-3.738v-.762C2,2.243,4.243,0,7,0h10.5c3.584,0,6.5,2.916,6.5,6.5Zm-11,3c0-1.379-1.121-2.5-2.5-2.5h-6c-1.379,0-2.5,1.121-2.5,2.5v10c0,1.379,1.121,2.5,2.5,2.5h6c1.379,0,2.5-1.121,2.5-2.5v-10Zm-1.836-4.433c.263-1.183.837-2.233,1.635-3.067h-5.799c-1.654,0-3,1.346-3,3v.051c.166-.019.329-.051.5-.051h6c.227,0,.446.034.664.067Zm-1.164,8.933h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Zm0,4h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Zm-4-4h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Zm0,4h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="m11,10v1c0,.552-.448,1-1,1h-5c-.552,0-1-.448-1-1v-1c0-.552.448-1,1-1h5c.552,0,1,.448,1,1Zm13-3.5v10.5c0,.357-.19.688-.5.866-.309.178-.69.178-.999,0l-2.17-1.25-1.767,1.209c-.172.118-.369.175-.563.175-.319,0-.633-.152-.826-.436-.312-.455-.195-1.077.261-1.39l2.285-1.564c.315-.217.731-.234,1.063-.041l1.216.7V6.5c0-2.481-2.019-4.5-4.5-4.5-2.249,0-4.097,1.624-4.431,3.815,1.164.814,1.931,2.16,1.931,3.685v10c0,2.481-2.019,4.5-4.5,4.5h-6c-2.481,0-4.5-2.019-4.5-4.5v-10c0-1.557.795-2.93,2-3.738v-.762C2,2.243,4.243,0,7,0h10.5c3.584,0,6.5,2.916,6.5,6.5Zm-11,3c0-1.379-1.121-2.5-2.5-2.5h-6c-1.379,0-2.5,1.121-2.5,2.5v10c0,1.379,1.121,2.5,2.5,2.5h6c1.379,0,2.5-1.121,2.5-2.5v-10Zm-1.836-4.433c.263-1.183.837-2.233,1.635-3.067h-5.799c-1.654,0-3,1.346-3,3v.051c.166-.019.329-.051.5-.051h6c.227,0,.446.034.664.067Zm-1.164,8.933h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Zm0,4h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Zm-4-4h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Zm0,4h-1c-.553,0-1,.447-1,1s.447,1,1,1h1c.553,0,1-.447,1-1s-.447-1-1-1Z"
                                            fill="#000000" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Daftar Pengajuan</span>
                        </a>
                    </div>
                @endrole

                @role('Customer')
                    <div class="menu-item">
                        <a class="menu-link {{ Request::is('myTicket') ? 'active' : '' }}"
                            href="{{ route('myTicket.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                            fill="#000000" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Tiket Saya</span>
                        </a>
                    </div>
                @endrole

                @role('Department')
                    <div class="menu-item">
                        <a class="menu-link {{ Request::is('unassignedTicket') ? 'active' : '' }}"
                            href="{{ route('unassignedTicket.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="m1.5,4c0-1.105.895-2,2-2s2,.895,2,2-.895,2-2,2-2-.895-2-2Zm10.5,0c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm8.5,2c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm-1.444,11.225l-6.056-1.705v-4.926c0-.704-.447-1.368-1.129-1.543-1.001-.256-1.884.492-1.884,1.449v9.269l-1.64-1.296c-.866-.722-2.153-.604-2.874.261-.722.866-.605,2.153.261,2.874l1.68,1.483c.663.585,1.516.908,2.4.908h.762c1.338,0,2.423-1.085,2.423-2.423v-2.94l5.219,1.469c1.065.319,1.781,1.281,1.781,2.395,0,.828.672,1.5,1.5,1.5s1.5-.672,1.5-1.5c0-2.448-1.575-4.565-3.944-5.275ZM6.948,9.027c-.506-1.159-1.859-1.989-3.448-1.989S.558,7.868.052,9.027c-.216.496.28,1.011.922,1.011h5.052c.642,0,1.139-.516.922-1.011Zm2.525-1.027h5.052c.642,0,1.139-.516.922-1.011-.506-1.159-1.859-1.989-3.448-1.989s-2.942.83-3.448,1.989c-.216.496.28,1.011.922,1.011Zm14.475.989c-.506-1.159-1.859-1.989-3.448-1.989s-2.942.83-3.448,1.989c-.216.496.28,1.011.922,1.011h5.052c.642,0,1.139-.516.922-1.011Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="m1.5,4c0-1.105.895-2,2-2s2,.895,2,2-.895,2-2,2-2-.895-2-2Zm10.5,0c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm8.5,2c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm-1.444,11.225l-6.056-1.705v-4.926c0-.704-.447-1.368-1.129-1.543-1.001-.256-1.884.492-1.884,1.449v9.269l-1.64-1.296c-.866-.722-2.153-.604-2.874.261-.722.866-.605,2.153.261,2.874l1.68,1.483c.663.585,1.516.908,2.4.908h.762c1.338,0,2.423-1.085,2.423-2.423v-2.94l5.219,1.469c1.065.319,1.781,1.281,1.781,2.395,0,.828.672,1.5,1.5,1.5s1.5-.672,1.5-1.5c0-2.448-1.575-4.565-3.944-5.275ZM6.948,9.027c-.506-1.159-1.859-1.989-3.448-1.989S.558,7.868.052,9.027c-.216.496.28,1.011.922,1.011h5.052c.642,0,1.139-.516.922-1.011Zm2.525-1.027h5.052c.642,0,1.139-.516.922-1.011-.506-1.159-1.859-1.989-3.448-1.989s-2.942.83-3.448,1.989c-.216.496.28,1.011.922,1.011Zm14.475.989c-.506-1.159-1.859-1.989-3.448-1.989s-2.942.83-3.448,1.989c-.216.496.28,1.011.922,1.011h5.052c.642,0,1.139-.516.922-1.011Z"
                                            fill="#000000" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Belum Ditetapkan</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::is('assignedTicket') ? 'active' : '' }}"
                            href="{{ route('assignedTicket.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="m15,16.769l8,3v4.231h-2v-2.845l-8-3v-6.048c0-.538-.362-1.018-.825-1.093-.304-.052-.595.03-.822.223-.224.19-.353.469-.353.763v11.712l-4.261-3.392.008-.01c-.021-.017-.047-.023-.067-.042-.402-.373-1.034-.354-1.41.048-.377.403-.356,1.038.046,1.416l2.352,2.268h-2.881l-.849-.818c-1.196-1.12-1.26-3.022-.13-4.23,1.109-1.188,2.963-1.263,4.173-.192l.003-.004,1.015.808v-7.563c0-.882.386-1.715,1.058-2.286.672-.572,1.56-.815,2.439-.674,1.427.232,2.503,1.552,2.503,3.067v4.661ZM3.5,6c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm1.5,4h2v-1c0-1.103-.897-2-2-2h-3c-1.103,0-2,.897-2,2v1h2v-1h3v1Zm15.5-4c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm1.5,1h-3c-1.103,0-2,.897-2,2v1h2v-1h3v1h2v-1c0-1.103-.897-2-2-2Zm-10-3c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm-1.5,3h3v1h2v-1c0-1.103-.897-2-2-2h-3c-1.103,0-2,.897-2,2v1h2v-1Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="m15,16.769l8,3v4.231h-2v-2.845l-8-3v-6.048c0-.538-.362-1.018-.825-1.093-.304-.052-.595.03-.822.223-.224.19-.353.469-.353.763v11.712l-4.261-3.392.008-.01c-.021-.017-.047-.023-.067-.042-.402-.373-1.034-.354-1.41.048-.377.403-.356,1.038.046,1.416l2.352,2.268h-2.881l-.849-.818c-1.196-1.12-1.26-3.022-.13-4.23,1.109-1.188,2.963-1.263,4.173-.192l.003-.004,1.015.808v-7.563c0-.882.386-1.715,1.058-2.286.672-.572,1.56-.815,2.439-.674,1.427.232,2.503,1.552,2.503,3.067v4.661ZM3.5,6c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm1.5,4h2v-1c0-1.103-.897-2-2-2h-3c-1.103,0-2,.897-2,2v1h2v-1h3v1Zm15.5-4c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm1.5,1h-3c-1.103,0-2,.897-2,2v1h2v-1h3v1h2v-1c0-1.103-.897-2-2-2Zm-10-3c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm-1.5,3h3v1h2v-1c0-1.103-.897-2-2-2h-3c-1.103,0-2,.897-2,2v1h2v-1Z"
                                            fill="#000000" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Sudah Ditetapkan</span>
                        </a>
                    </div>
                @endrole
            @endcan
        </div>
        <!--end::Menu-->
    </div>
</div>
