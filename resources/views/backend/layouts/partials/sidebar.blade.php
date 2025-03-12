<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
            <img src="{{ asset('backend/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                height="20" />
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

</div>

<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">

            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <p>Tổng Quan</p>
                </a>
            </li>

            <li class="nav-item {{ request()->route('number') == 8 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 8) }}">
                    <p>Cấu Hình Chung</p>

                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.contact.index') ? 'active' : '' }}">
                <a href="{{ route('admin.contact.index') }}">
                    <p>Danh Dách Yêu Cầu</p>
                </a>
            </li>
            <li class="nav-item {{ request()->route('number') == 1 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 1) }}">
                    <p>Cấu Hình Section 1</p>
                </a>
            </li>

            <li class="nav-item {{ request()->route('number') == 2 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 2) }}">
                    <p>Cấu Hình Section 2</p>
                </a>
            </li>

            <li class="nav-item {{ request()->route('number') == 3 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 3) }}">
                    <p>Cấu Hình Section 3</p>
                </a>
            </li>

            <li class="nav-item {{ request()->route('number') == 4 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 4) }}">
                    <p>Cấu Hình Section 4</p>
                </a>
            </li>

            <li class="nav-item {{ request()->route('number') == 5 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 5) }}">
                    <p>Cấu Hình Section 5</p>
                </a>
            </li>

            <li class="nav-item {{ request()->route('number') == 6 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 6) }}">
                    <p>Cấu Hình Section 6</p>
                </a>
            </li>

            <li class="nav-item {{ request()->route('number') == 7 ? 'active' : '' }}">
                <a href="{{ route('admin.section.config.view', 7) }}">
                    <p>Cấu Hình Section 7</p>
                </a>
            </li>

        </ul>
    </div>
</div>
