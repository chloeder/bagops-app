        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('img/bagops.png') }}" style="width: 50px" alt="">
                </div>
                <div class="sidebar-brand-text ">LAPOR-OPS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Route::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if (Auth::user()->role == 'admin')
                <!-- Heading -->
                <div class="sidebar-heading">
                    Kategori
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item {{ Route::is('kategori*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('kategori') }}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">
            @endif

            <!-- Heading -->
            <div class="sidebar-heading">
                Dokumen
            </div>

            @if (Auth::user()->role == 'user')
                <!-- Nav Item - Charts -->
                <li class="nav-item {{ Route::is('berkas*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('berkas') }}">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Berkas</span>
                    </a>
                </li>
            @endif



            @if (Auth::user()->role == 'admin')
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item {{ Route::is('dokumen.berkas*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                        aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Berkas</span>
                    </a>
                    <div id="collapsePages" class="collapse" aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Berkas Dikumpulkan</h6>
                            <a class="collapse-item {{ Route::is('dokumen.berkas') ? 'active' : '' }}"
                                href="{{ route('dokumen.berkas') }}">Berkas</a>
                            <div class="collapse-divider"></div>
                            <h6 class="collapse-header">Status Berkas</h6>
                            <a class="collapse-item {{ Route::is('dokumen.berkas.tertunda') ? 'active' : '' }}"
                                href="{{ route('dokumen.berkas.tertunda') }}">Berkas Baru</a>
                            <a class="collapse-item {{ Route::is('dokumen.berkas.ditolak') ? 'active' : '' }}"
                                href="{{ route('dokumen.berkas.ditolak') }}">Berkas Ditolak</a>.
                        </div>
                    </div>
                </li>

                <!-- Divider -->
            @endif
            <hr class="sidebar-divider d-none d-md-block">

            <div class="sidebar-heading">
                Pengaturan
            </div>

            @if (Auth::user()->role == 'user')
                <!-- Nav Item - Charts -->
                <li class="nav-item {{ Route::is('laporan.berkas*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('laporan.berkas') }}">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Laporan Berkas</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->role == 'admin')
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item {{ Route::is('user.list') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse"
                        aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Administrator</span>
                    </a>
                    <div id="collapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Kelola User</h6>
                            <a class="collapse-item {{ Route::is('user.list') ? 'active' : '' }}"
                                href="{{ route('user.list') }}">User List</a>
                            <div class="collapse-divider"></div>
                            <h6 class="collapse-header">Pelaporan Berkas</h6>
                            <a class="collapse-item {{ Route::is('laporan.berkas') ? 'active' : '' }}"
                                href="{{ route('laporan.berkas') }}">Laporan Berkas</a>
                        </div>
                    </div>
                </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
