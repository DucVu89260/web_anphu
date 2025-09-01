<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg main-nav">
    <div class="container">
        <button
            class="navbar-toggler bg-white"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">

                {{-- Dự án --}}
                <li class="nav-item mx-2 {{ request()->routeIs('admin.portfolios.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.portfolios.index') }}">
                        <i class="fa fa-home mr-1"></i> Dự án
                    </a>
                </li>

                {{-- Bài đăng --}}
                <li class="nav-item mx-2 {{ request()->routeIs('admin.articles.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.articles.index') }}">
                        <i class="fa fa-newspaper me-1"></i> Bài đăng
                    </a>
                </li>

                {{-- Lịch tư vấn --}}
                <li class="nav-item mx-2 {{ request()->routeIs('admin.consulting_requests.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.consulting_requests.index') }}">
                        <i class="fa fa-calendar-check mr-1"></i> Lịch tư vấn
                    </a>
                </li>

                {{-- Dịch vụ --}}
                <li class="nav-item mx-2 {{ request()->routeIs('admin.services.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.services.index') }}">
                        <i class="fa fa-circle-check"></i> Dịch vụ
                    </a>
                </li>

                {{-- Custom Pages --}}
                <li class="nav-item mx-2 {{ request()->routeIs('admin.custom_pages.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.custom_pages.index') }}">
                        <i class="fa fa-newspaper me-1"></i> Quản lý trang
                    </a>
                </li>

                {{-- Admins --}}
                @if(auth()->user()->level == 1)
                <li class="nav-item mx-2 {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <i class="fa fa-users"></i> Quản lý Admin
                    </a>
                </li>
                @endif

                {{-- Dropdown: Cài đặt --}}
                <li
                    class="nav-item dropdown mx-2 mx-lg-3 my-1 my-lg-0 small
                    {{
                        request()->routeIs(
                            'admin.settings.*',
                            'admin.partners.index',
                            'admin.categories.index'
                        ) ? 'active' : '' 
                    }}"
                >
                    <a class="nav-link dropdown-toggle text-center" href="#" id="settingsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cogs mr-1"></i> Cài đặt
                    </a>
                    <div class="dropdown-menu" aria-labelledby="settingsDropdown">
                        @if(auth()->user()->level == 1)
                            <a
                                class="dropdown-item small {{ request()->routeIs('admin.settings.company.edit') ? 'active' : '' }}"
                                href="{{ route('admin.settings.company.edit') }}"
                            >
                                <i class="fa fa-cog mr-1 icon-highlight"></i> Cài đặt thông tin công ty
                            </a>
                            <a
                                class="dropdown-item small {{ request()->routeIs('admin.settings.company.editPolicy') ? 'active' : '' }}"
                                href="{{ route('admin.settings.company.editPolicy') }}"
                            >
                                <i class="fa fa-cog mr-1 icon-highlight"></i> Cài đặt chính sách công ty
                            </a>
                        @endif
                        <a
                            class="dropdown-item small {{ request()->routeIs('admin.partners.index') ? 'active' : '' }}"
                            href="{{ route('admin.partners.index') }}"
                        >
                            <i class="fa fa-cog mr-1 icon-highlight"></i> Cài đặt đối tác công ty
                        </a>
                        <a
                            class="dropdown-item small {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"

                            href="{{ route('admin.categories.index') }}"
                        >
                            <i class="fa fa-cog mr-1 icon-highlight"></i> Cài đặt danh mục
                        </a>

                        <a
                            class="dropdown-item small {{ request()->routeIs('admin.facebook.index') ? 'active' : '' }}"

                            href="{{ route('admin.facebook.index') }}"
                        >
                            <i class="fa-brands fa-facebook-f mr-1 icon-highlight"></i> FacebookApp
                        </a>
                    </div>
                </li>

                <li class="nav-item mx-2 {{ request()->routeIs('admin.custom_pages.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.auths.logout') }}" class="btn btn-danger px-4">
                        <i class="fas fa-sign-out-alt me-1"></i>Đăng xuất
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
