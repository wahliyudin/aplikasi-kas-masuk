<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/master-data/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/master-data/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-server"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.account-types.index') }}"
                                class="nav-link {{ request()->routeIs('admin.account-types.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Akun</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.accounts.index') }}"
                                class="nav-link {{ request()->routeIs('admin.accounts.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Akun</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.students.index') }}"
                                class="nav-link {{ request()->routeIs('admin.students.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data SIswa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.cash-ins.index') }}"
                        class="nav-link {{ request()->routeIs('admin.cash-ins.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Kas Masuk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}"
                        class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.product-out.index') }}"
                        class="nav-link {{ request()->routeIs('admin.product-out.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-upload"></i>
                        <p>
                            Barang Keluar
                        </p>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.attendances.index') }}"
                        class="nav-link {{ request()->routeIs('admin.attendances.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                            Data Absen
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.salaries.index') }}"
                        class="nav-link {{ request()->routeIs('admin.salaries.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Data Gaji
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>{{ __('Logout') }}</p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
