                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-dark" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> --}}

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Untuk Admin -->
                        @if (Auth::user()->role == 'admin')
                            {{-- Notifikasi --}}
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->

                                    <span class="badge badge-danger badge-counter">
                                        {{ $newuser->count() }}
                                    </span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Notifikasi
                                    </h6>
                                    @forelse($newuser as $n)
                                        <a class="dropdown-item d-flex align-items-center mark-as-read"
                                            href="{{ route('user.list') }}" data-id="{{ $n->id }}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-dark">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="small text-gray-500">
                                                    {{ $n->created_at->diffForHumans() }}
                                                </div>
                                                Akun baru telah didaftarkan dengan username
                                                <span class="font-weight-bold">{{ $n->data['nama_user'] }}
                                                </span>
                                            </div>
                                        </a>
                                        @if ($loop->last)
                                            <a class="dropdown-item text-center small text-gray-500"
                                                href="{{ route('user.list') }}">Lihat
                                                Semua
                                                User
                                            </a>
                                        @endif
                                    @empty
                                        Tidak ada Notifikasi Baru
                                    @endforelse
                                </div>
                            </li>
                            {{-- End Notifikasi --}}

                            {{-- Pesan Berkas --}}
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                    <!-- Counter - Messages -->
                                    <span class="badge badge-danger badge-counter">{{ $newberkas->count() }}
                                    </span>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Pesan
                                    </h6>
                                    @forelse($newberkas as $c)
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('dokumen.berkas.tertunda') }}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-dark">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="small text-gray-500">
                                                    {{ $c->created_at->diffForHumans() }}
                                                </div>
                                                <span class="font-weight-bold">{{ $c->data['nama'] }}
                                                    ({{ $c->data['satker'] }})
                                                    ,
                                                </span>
                                                telah mengirimkan berkas dengan nomor
                                                <span class="font-weight-bold">{{ $c->data['no_berkas'] }}
                                                </span>
                                            </div>
                                        </a>
                                        <a class="dropdown-item text-center small text-gray-500"
                                            href="{{ route('dokumen.berkas.tertunda') }}">Lihat Semua
                                            Berkas Baru</a>
                                    @empty
                                        Tidak ada Pesan Baru
                                    @endforelse
                                </div>
                            </li>
                            {{-- End Pesan Berkas --}}
                        @endif

                        <!-- Nav Item - Untuk User -->
                        @if (Auth::user()->role == 'user')
                            {{-- Notifikasi --}}
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->

                                    <span class="badge badge-danger badge-counter">
                                        {{ $categorynotif->count() }}
                                    </span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Notifikasi
                                    </h6>
                                    @forelse($categorynotif as $n)
                                        <a class="dropdown-item d-flex align-items-center mark-as-read"
                                            href="{{ route('berkas') }}" data-id="{{ $n->id }}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-dark">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="small text-gray-500">
                                                    {{ $n->created_at->diffForHumans() }}
                                                </div>
                                                Kategori
                                                <span class="font-weight-bold">{{ $n->data['category_name'] }}
                                                </span>
                                                telah <span class="font-weight-bold">{{ $n->data['status'] }}
                                                </span>
                                            </div>
                                        </a>
                                    @empty
                                        Tidak ada Notifikasi Baru
                                    @endforelse
                                </div>
                            </li>
                            {{-- End Notifikasi --}}
                            {{-- Pesan --}}
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown"
                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                    <!-- Counter - Messages -->
                                    <span class="badge badge-danger badge-counter">{{ $statusberkas->count() }}
                                    </span>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Notification
                                    </h6>
                                    @forelse($statusberkas as $c)
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('berkas') }}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-dark">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="small text-gray-500">
                                                    {{ $c->created_at->diffForHumans() }}
                                                </div>
                                                @if ($c->data['status'] == 'Diterima')
                                                    Berkas anda dengan nomor
                                                    <span class="badge badge-dark">{{ $c->data['no_berkas'] }}
                                                    </span> :
                                                    <span class="badge badge-success">{{ $c->data['status'] }}</span>
                                                @elseif($c->data['status'] == 'Ditolak')
                                                    Berkas anda dengan nomor
                                                    <span class="badge badge-dark">{{ $c->data['no_berkas'] }}
                                                    </span> :
                                                    <span class="badge badge-danger">{{ $c->data['status'] }}</span>
                                                @else
                                                    Berkas anda dengan nomor
                                                    <span class="badge badge-dark">{{ $c->data['no_berkas'] }}
                                                    </span> :
                                                    <span class="badge badge-warning">{{ $c->data['status'] }}</span>
                                                @endif

                                            </div>
                                        </a>
                                    @empty
                                        Tidak ada Notifikasi Baru
                                    @endforelse

                                </div>
                            </li>
                        @endif

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-500"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>

                            </div>
                        </li>

                    </ul>

                </nav>
