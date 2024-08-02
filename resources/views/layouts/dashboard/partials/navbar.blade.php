<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
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
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            {{-- <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input type="text" placeholder="Search ..." class="form-control" />
                </div>
            </nav> --}}

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                        <form class="navbar-left navbar-form nav-search">
                            <div class="input-group">
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </form>
                    </ul>
                </li>

                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        @if (auth()->user()->unreadNotifications->count() != 0)
                            <span class="notification">
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                You have {{ auth()->user()->unreadNotifications->count() }} new notifications
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-persetujuan"
                                            style="width: 120px">Persetujuan
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
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab-komentar"
                                            style="width: 120px">Komentar
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
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab-persetujuan">
                                        <div class="notif-center">
                                            @foreach (auth()->user()->unreadNotifications as $notification)
                                                @if (isset($notification->data['type']) && $notification->data['type'] == 'comment')
                                                    @continue
                                                @endif
                                                <form
                                                    action="{{ route('notifications.mark-as-read', ['notification' => $notification->id]) }}"
                                                    method="POST" class="notification-form">
                                                    @csrf
                                                    @method('PATCH')

                                                    <a href="{{ $notification->data['Url'] }}"
                                                        class="fs-6 text-gray-800 text-hover-primary fw-bolder notification-link">
                                                        <div class="notif-icon notif-primary" style="size: 20px">
                                                            <i class="fa fa-bell"></i>
                                                        </div>
                                                        <div class="notif-content"
                                                            onclick="submitForm('form-{{ $notification->id }}')">
                                                            <span
                                                                class="block">{{ $notification->data['name'] }}</span>
                                                            <span
                                                                class="time">{{ $notification->created_at->locale('id')->diffForHumans() }}</span>
                                                                <div class="text-gray-10 fs-7" style="font-size: 10px">
                                                                    {{ ucwords($notification->data['body']) }}
                                                                </div>
                                                        </div>
                                                    </a>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab-komentar">
                                        <div class="notif-center">
                                            @foreach (auth()->user()->unreadNotifications as $notification)
                                                @if (!isset($notification->data['type']) || $notification->data['type'] != 'comment')
                                                    @continue
                                                @endif
                                                <form
                                                    action="{{ route('notifications.mark-as-read', ['notification' => $notification->id]) }}"
                                                    method="POST" class="notification-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <a href="{{ $notification->data['Url'] }}"
                                                        class="fs-6 text-gray-800 text-hover-primary fw-bolder notification-link">
                                                        <div class="notif-icon notif-primary" style="size: 20px">
                                                            <i class="fa fa-comment"></i>
                                                        </div>
                                                        <div class="notif-content">
                                                            <span
                                                                class="block">{{ $notification->data['name'] }}</span>
                                                            <span
                                                                class="time">{{ $notification->created_at->locale('id')->diffForHumans() }}</span>
                                                                <div class="text-gray-10 fs-7" style="font-size: 10px">
                                                                    {{ ucwords($notification->data['body']) }}
                                                                </div>
                                                        </div>
                                                    </a>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            {{-- <a class="see-all" href="javascript:void(0);">See all notifications<i
                                    class="fa fa-angle-right"></i></a> --}}
                        </li>
                    </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            @if (Auth::user()->gender == 'Pria')
                                <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                    alt="profile-user" class="avatar-img rounded-circle" />
                            @else
                                <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                    alt="profile-user" class="avatar-img rounded-circle" />
                            @endif
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        @if (Auth::user()->gender == 'Pria')
                                            <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                                alt="image profile" class="avatar-img rounded" />
                                        @else
                                            <img src="{{ asset(Auth::user()->photo ? Auth::user()->photo : 'template/dist/assets/media/avatars/blank.png') }}"
                                                alt="image profile" class="avatar-img rounded" />
                                        @endif
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()->id) }}">My
                                    Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
