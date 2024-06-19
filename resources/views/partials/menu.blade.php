<!-- Left Menu Start -->
<ul class="metismenu list-unstyled" id="side-menu">
    {{-- <li class="menu-title">Menu</li> --}}

    @can('dashboard_access')
        <li>
            <a href="{{ route('admin.home') }}" class="nav-link {{ request()->is('admin/home') || request()->is('admin/home/*') ? 'active' : '' }}">
    <img src="{{ asset('img/icons/dashboard-monitor.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
    <span>{{ trans('global.dashboard') }}</span>
</a>
        </li>
    @endcan

    @can('user_management_access')
        <li>
            <a href="javascript: void(0);" class="nav-link {{ request()->is('admin/permissions','admin/roles', 'admin/users') || request()->is('admin/permissions/*', 'admin/roles/*'. 'admin/users/*') ? 'active' : '' }}">
                <img src="{{ asset('img/icons/network-analytic.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
                <span>{{ trans('cruds.userManagement.title') }}</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                @can('permission_access')
                    <li>
                        <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <img src="{{ asset('img/icons/briefcase.svg') }}" alt="Dashboard Icon" class="nav-icon" height="20">
                            <span>{{ trans('cruds.permission.title') }}</span>
                        </a>
                    </li>
                @endcan
                @can('role_access')
                    <li>
                        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <img src="{{ asset('img/icons/practice.svg') }}" alt="Dashboard Icon" class="nav-icon" height="20">
                            <span>{{ trans('cruds.role.title') }}</span>
                        </a>
                    </li>
                @endcan
                @can('user_access')
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <img src="{{ asset('img/icons/member-list.svg') }}" alt="Dashboard Icon" class="nav-icon" height="20">
                            <span>{{ trans('cruds.user.title') }}</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('status_access')
        <li>
            <a href="{{ route('admin.statuses.index') }}" class="nav-link {{ request()->is('admin/statuses') || request()->is('admin/statuses/*') ? 'active' : '' }}">
                <img src="{{ asset('img/icons/career-growth.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
                <span>{{ trans('cruds.status.title') }}</span>
            </a>
        </li>
    @endcan
    @can('priority_access')
        <li>
            <a href="{{ route('admin.priorities.index') }}" class="nav-link {{ request()->is('admin/priorities') || request()->is('admin/priorities/*') ? 'active' : '' }}">
                <img src="{{ asset('img/icons/priority-arrow.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
                <span>{{ trans('cruds.priority.title') }}</span>
            </a>
        </li>
    @endcan
    @can('category_access')
        <li>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                <img src="{{ asset('img/icons/category.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
                <span>{{ trans('cruds.category.title') }}</span>
            </a>
        </li>
    @endcan
    @can('ticket_access')
        <li>
            <a href="{{ route('admin.tickets.index') }}" class="nav-link {{ request()->is('admin/tickets') || request()->is('admin/tickets/*') ? 'active' : '' }}">
                <img src="{{ asset('img/icons/comments-question-check.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
                <span>{{ trans('cruds.ticket.title') }}</span>
            </a>
        </li>
    @endcan
    @can('comment_access')
        <li>
            <a href="{{ route('admin.comments.index') }}" class="nav-link {{ request()->is('admin/comments') || request()->is('admin/comments/*') ? 'active' : '' }}">
                <img src="{{ asset('img/icons/comment-dots.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
                <span>{{ trans('cruds.comment.title') }}</span>
            </a>
        </li>
    @endcan
    @can('helpdesk_access')
        <li>
            <a href="{{ route('admin.helpdesks.index') }}" class="nav-link {{ request()->is('helpdesks') || request()->is('admin/helpdesks/*') ? 'active' : '' }}">
                <img src="{{ asset('img/icons/seal-question.svg') }}" alt="Dashboard Icon" class="nav-icon" height="24">
                <span>{{ trans('cruds.helpdesk.title') }}</span>
            </a>
        </li>
    @endcan
</ul>





<style>
    .sidebar {
        font-family: 'Arial', sans-serif;
    }

    .nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        display: block;
        padding: 20px 20px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        width: 100%;
        text-decoration: none;
         -webkit-text-fill-color: white;
        transition: background 0.3s ease;
    }

    .nav-link:hover {
        color: #ffffff;
        text-decoration: none;
        background: #e3ca4b48;

      }

      .nav-link.active {
            color: white; /* Gaya untuk link aktif */
            background-color: #5a37e7; /* Gaya untuk link aktif */
            -webkit-text-fill-color: white;
            color
      }

    .nav-icon {
        margin-right: 10px;
        font-size: 18px;
    }

    .nav-icon.nav-link.active {
        margin-right: 10px;
        font-size: 18px;
        border-color: #ffffff
    }

    .nav-dropdown-toggle::after {
        content: '▼';
        margin-left: auto;
        font-size: 12px;
        transition: transform 0.3s ease;
    }

    .nav-dropdown-items {
        list-style: none;
        padding-left: 20px;
        display: none;
    }

    .nav-dropdown.active>.nav-link .nav-dropdown-toggle::after {
        transform: rotate(180deg);
    }

    .nav-dropdown.active .nav-dropdown-items {
        display: block;
    }

    .nav-item.nav-dropdown>.nav-link {
        cursor: pointer;
    }

    .icon-inactive {
        color: white;
    }

    .icon-active {
        color: inherit;
        /* Atau warna lain yang diinginkan saat ikon aktif */
    }
</style>

<script>
    document.querySelectorAll('.nav-dropdown-toggle').forEach(function(dropdown) {
        dropdown.addEventListener('click', function() {
            this.parentElement.classList.toggle('active');
        });
    });
</script>
