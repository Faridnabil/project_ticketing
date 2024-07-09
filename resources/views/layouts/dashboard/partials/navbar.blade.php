<!--begin::Wrapper-->
<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
    <!--begin::Navbar-->
    <div class="d-flex align-items-stretch" id="kt_header_nav">
        <!--begin::Menu wrapper-->
        <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
            data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
            data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-place="true" data-kt-place-mode="prepend"
            data-kt-place-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
            <!--begin::Menu-->
            <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                id="#kt_header_menu" data-kt-menu="true">
                {{-- <div class="menu-item me-lg-1">
                    <a class="menu-link active py-3" href="index.html">
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div> --}}
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::Navbar-->
    <!--begin::Topbar-->
    <div class="d-flex align-items-stretch flex-shrink-0">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex align-items-stretch flex-shrink-0">

            <!--begin::Notifications-->
            <div class="d-flex align-items-center ms-1 ms-lg-3">
                <!--begin::Menu- wrapper-->
                <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px"
                    data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                    data-kt-menu-flip="bottom">
                    <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                            version="1.1">
                            <path
                                d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                                fill="#000000" opacity="0.3" />
                            <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4"
                                rx="2"></rect>
                            <path
                                d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                                fill="#000000" />
                            <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4"
                                rx="2">
                                @if (auth()->user()->unreadNotifications->count() != 0)
                                    <div
                                        class="position-absolute translate-middle bottom-0 ma-3 mb-3 bg-danger rounded-circle border border-3 border-white h-15px w-15px">
                                    </div>
                                @endif
                            </rect>
                        </svg>

                    </span>

                    <!--end::Svg Icon-->
                </div>
                <!--begin::Menu Notifikasi-->
                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column bgi-no-repeat rounded-top"
                        style="background-image:url('{{ asset('template/dist/assets/media//misc/pattern-1.jpg') }}')">
                        <!--begin::Title-->
                        <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifikasi
                        </h3>
                        <!--end::Title-->
                        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
                            <!-- Persetujuan Tab -->
                            <li class="nav-item">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                                    data-bs-toggle="tab" href="#kt_topbar_notifications_1">Persetujuan
                                    @php
                                        $persetujuanCount = auth()
                                            ->user()
                                            ->unreadNotifications->filter(function ($notification) {
                                                return !isset($notification->data['type']) ||
                                                    $notification->data['type'] != 'comment';
                                            })
                                            ->count();
                                    @endphp
                                    @if ($persetujuanCount > 0)
                                        <span class="badge bg-danger"
                                            style="margin-left: 5px">{{ $persetujuanCount }}</span>
                                    @endif
                                </a>
                            </li>

                            <!-- Komentar Tab -->
                            <li class="nav-item">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                                    href="#kt_topbar_notifications_2">Komentar
                                    @php
                                        $komentarCount = auth()
                                            ->user()
                                            ->unreadNotifications->filter(function ($notification) {
                                                return isset($notification->data['type']) &&
                                                    $notification->data['type'] == 'comment';
                                            })
                                            ->count();
                                    @endphp
                                    @if ($komentarCount > 0)
                                        <span class="badge bg-danger"
                                            style="margin-left: 5px">{{ $komentarCount }}</span>
                                    @endif
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab panel-->
                        <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                            <!--begin::Items-->
                            <div class="scroll-y mh-325px my-5 px-8">

                                @foreach (auth()->user()->unreadNotifications as $notification)
                                    @if (isset($notification->data['type']) && $notification->data['type'] == 'comment')
                                        @continue
                                    @endif
                                    <!-- Notifikasi Biasa -->
                                    <div class="d-flex flex-stack py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-primary">
                                                    <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                        <!-- Svg Icon for Other Notifications -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <path
                                                                d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                                id="Combined-Shape" fill="#000000" opacity="0.3" />
                                                            <path
                                                                d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                                id="Combined-Shape" fill="#000000" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="mb-0 me-2">
                                                <a href="{{ $notification->data['Url'] }}"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bolder">{{ $notification->data['name'] }}</a>
                                                <div class="text-gray-400 fs-7">
                                                    {{ ucwords($notification->data['body']) }}</div>
                                            </div>
                                        </div>
                                        <span
                                            class="badge badge-light fs-8">{{ $notification->created_at->locale('id')->diffForHumans() }}</span>
                                    </div>
                                    <form
                                        action="{{ route('notifications.mark-as-read', ['notification' => $notification->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link btn-sm"
                                            style="margin-left: 15%"><span class="badge bg-danger">Sudah
                                                dibaca</span></button>
                                    </form>
                                @endforeach

                            </div>
                            <!--end::Items-->
                            <!--begin::View more-->
                            <div class="py-3 text-center border-top">
                                <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                                    @csrf
                                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                    <button type="submit" class="btn btn-color-gray-600 btn-active-color-primary">Hapus
                                        Notif
                                        <span class="svg-icon svg-icon-5">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <rect fill="#000000" opacity="0.5"
                                                        transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                                        x="7.5" y="7.5" width="2" height="9"
                                                        rx="1" />
                                                    <path
                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                </g>
                                            </svg>
                                        </span>
                                    </button>
                                    <!--end::Svg Icon-->
                                </form>


                            </div>
                            <!--end::View more-->
                        </div>
                        <!--end::Tab panel-->

                        <!--begin::Tab panel-->
                        <div class="tab-pane fade" id="kt_topbar_notifications_2" role="tabpanel">
                            <!--begin::Items-->
                            <div class="scroll-y mh-325px my-5 px-8">

                                @foreach (auth()->user()->unreadNotifications as $notification)
                                    @if (isset($notification->data['type']) && $notification->data['type'] == 'comment')
                                        <!-- Notifikasi Komentar -->
                                        <div class="d-flex flex-stack py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                            <!-- Svg Icon for Comment -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <path
                                                                    d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                                    id="Combined-Shape" fill="#000000"
                                                                    opacity="0.3" />
                                                                <path
                                                                    d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                                    id="Combined-Shape" fill="#000000" />
                                                            </svg>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mb-0 me-2">
                                                    <a href="{{ $notification->data['Url'] }}"
                                                        class="fs-6 text-gray-800 text-hover-primary fw-bolder">{{ $notification->data['name'] }}</a>
                                                    <div class="text-gray-400 fs-7">
                                                        {{ ucwords($notification->data['body']) }}</div>
                                                </div>
                                            </div>
                                            <span
                                                class="badge badge-light fs-8">{{ $notification->created_at->locale('id')->diffForHumans() }}</span>
                                        </div>
                                        <form
                                            action="{{ route('notifications.mark-as-read', ['notification' => $notification->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-link btn-sm"
                                                style="margin-left: 15%"><span class="badge bg-danger">Sudah
                                                    dibaca</span></button>
                                        </form>
                                    @endif
                                @endforeach


                            </div>
                            <!--end::Items-->
                            <!--begin::View more-->
                            <div class="py-3 text-center border-top">
                                <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                                    @csrf
                                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                    <button type="submit"
                                        class="btn btn-color-gray-600 btn-active-color-primary">Hapus
                                        Notif
                                        <span class="svg-icon svg-icon-5">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <rect fill="#000000" opacity="0.5"
                                                        transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                                        x="7.5" y="7.5" width="2" height="9"
                                                        rx="1" />
                                                    <path
                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                </g>
                                            </svg>
                                        </span>
                                    </button>
                                    <!--end::Svg Icon-->
                                </form>


                            </div>
                            <!--end::View more-->
                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Notifications-->

            <!--begin::User-->
            <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                    data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                    @if (Auth::user()->gender == 'Pria')
                        <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                            class="rounded me-2 thumb-sm" alt="profile-user"
                            style="border: 1px solid rgb(196, 196, 196); border-radius: 4px;">
                    @else
                        <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                            class="rounded-circle me-2 thumb-sm" alt="profile-user"
                            style="border: 1px solid rgb(196, 196, 196); border-radius: 4px;">
                    @endif
                </div>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
                                @if (Auth::user()->gender == 'Pria')
                                    <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                        class="rounded me-2 thumb-sm" alt="profile-user"
                                        style="border: 1px solid rgb(196, 196, 196); border-radius: 4px;">
                                @else
                                    <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                        class="rounded-circle me-2 thumb-sm" alt="profile-user"
                                        style="border: 1px solid rgb(196, 196, 196); border-radius: 4px;">
                                @endif
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bolder d-flex align-items-center fs-5">{{ Auth::user()->name }}
                                    <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
                                </div>
                                <a href="#"
                                    class="fw-bold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ route('profile.edit', Auth::user()->id) }}" class="menu-link px-5">Profil</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="menu-link px-5">Sign Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::User -->
            <!--begin::Heaeder menu toggle-->
            <div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
                <div class="btn btn-icon btn-active-light-primary" id="kt_header_menu_mobile_toggle">
                    <!--begin::Svg Icon | path: icons/duotone/Text/Toggle-Right.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M22 11.5C22 12.3284 21.3284 13 20.5 13H3.5C2.6716 13 2 12.3284 2 11.5C2 10.6716 2.6716 10 3.5 10H20.5C21.3284 10 22 10.6716 22 11.5Z"
                                    fill="black" />
                                <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.5 20C15.3284 20 16 19.3284 16 18.5C16 17.6716 15.3284 17 14.5 17H3.5C2.6716 17 2 17.6716 2 18.5C2 19.3284 2.6716 20 3.5 20H14.5ZM8.5 6C9.3284 6 10 5.32843 10 4.5C10 3.67157 9.3284 3 8.5 3H3.5C2.6716 3 2 3.67157 2 4.5C2 5.32843 2.6716 6 3.5 6H8.5Z"
                                    fill="black" />
                            </g>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
            </div>
            <!--end::Heaeder menu toggle-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Topbar-->
</div>
<!--end::Wrapper-->
