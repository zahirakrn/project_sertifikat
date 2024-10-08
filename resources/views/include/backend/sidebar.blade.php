<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="" class="app-brand-link">
            <img src="{{asset('admin/assets/img/layouts/logo.JPG')}}" width="20%" height="20%">
             <span class="app-brand-text demo menu-text fw-bolder ms-3"></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
         <li class="menu-item">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('training.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Layouts">Training</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('sertifikat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Layouts">Sertifikat</div>
            </a>
        </li>
        @if (Auth::check() && Auth::user()->roles_id == 2)
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">( Super Admin Only )</span>
            </li>
            {{-- 2 untuk Super Admin --}}
            <li
                class="menu-item {{ request()->routeIs('user.index') || request()->routeIs('role.index') ? 'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                    <div data-i18n="Account Settings">Role Access </div>
                </a>
                <ul
                    class="menu-sub {{ request()->routeIs('user.index') || request()->routeIs('role.index') ? 'show' : '' }}">
                    <li class="menu-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class="menu-link">
                            <div data-i18n="Account">User</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('role.index') ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}" class="menu-link">
                            <div data-i18n="Account">Role</div>
                        </a>
                    </li>


                </ul>
            </li>
        @endif

    </ul>
</aside>
