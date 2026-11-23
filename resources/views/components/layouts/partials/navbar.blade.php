<!-- Navbar -->
<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">

        <!-- Left Side -->
        <div class="navbar-nav align-items-center d-flex flex-row">

            {{-- Theme --}}
            <div class="nav-item dropdown-style-switcher dropdown me-2">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ti ti-md"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-start dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle">
                                <i class="ti ti-sun me-2"></i>{{ __('layout.light') }}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle">
                                <i class="ti ti-moon me-2"></i>{{ __('layout.dark') }}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle">
                                <i class="ti ti-device-desktop me-2"></i>{{ __('layout.system') }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Language --}}
            <div class="nav-item dropdown-style-switcher dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ti ti-language"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-start dropdown-styles">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                           href="{{ route('lang.switch', 'en') }}">
                            <span class="align-middle">
                                <i class="ti ti-world me-2"></i>English
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
                           href="{{ route('lang.switch', 'ar') }}" data-text-direction="rtl" data-language="ar">
                            <span class="align-middle">
                                <i class="ti ti-world me-2"></i>العربية
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Right Side -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <li class="nav-item navbar-dropdown dropdown-user dropdown">

                <a class="nav-link dropdown-toggle hide-arrow"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown">

                    <div class="avatar avatar-online">
                        <img src="../../assets/img/avatars/1.png"
                             alt=""
                             class="h-auto rounded-circle">
                    </div>

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <div class="d-flex">

                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="../../assets/img/avatars/1.png"
                                             alt=""
                                             class="h-auto rounded-circle">
                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block">
                                        Mariam Mansour
                                    </span>
                                    <small class="text-muted">
                                        {{ __('layout.admin') }}
                                    </small>
                                </div>

                            </div>
                        </a>
                    </li>

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="ti ti-user-check me-2 ti-sm"></i>
                            <span class="align-middle">
                                {{ __('layout.my_profile') }}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ti ti-settings me-2 ti-sm"></i>
                            <span class="align-middle">
                                {{ __('layout.settings') }}
                            </span>
                        </a>
                    </li>

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="dropdown-item">
                                <i class="ti ti-logout me-2 ti-sm"></i>
                                <span class="align-middle">
                                    {{ __('layout.log_out') }}
                                </span>
                            </button>
                        </form>
                    </li>

                </ul>

            </li>

        </ul>

    </div>

</nav>
<!-- / Navbar -->
