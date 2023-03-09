@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="{{ route('cetak.grafik') }}" target="_blank"
                class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Cetak Grafik Laporan</a>
        </div>

        <!-- Untuk User -->
        @if (Auth::user()->role == 'user')
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="{{ route('berkas') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Berkas telah Dimasukkan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $berkas }} Berkas</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-folder fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a href="{{ route('berkas') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Berkas Tepat Waktu</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $diterima }} Berkas</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-folder-check fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <a href="{{ route('berkas') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Berkas Terlambat</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $terlambat }} Berkas</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-folder-x fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <a href="{{ route('berkas') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Total Berkas Ditolak</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ditolak }} Berkas</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-people-fill fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Untuk Admin -->
        @if (Auth::user()->role == 'admin')
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="{{ route('dokumen.berkas') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Berkas Masuk</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $berkas }} Berkas
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-folder fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-dark shadow h-100 py-2">
                        <a href="{{ route('kategori') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            Total Kategori</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $category }} Kategori
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-list-task fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <a href="{{ route('dokumen.berkas.tertunda') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Berkas Baru</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $tertunda }} Berkas</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-folder-minus fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a href="{{ route('user.list') }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total User</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-people-fill fa-2x text-gray-500"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Chart --}}
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-dark">Laporan Bulanan</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div id="chart-area">
                            <div id="grafik"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-dark">Laporan Pemasukkan Berkas</h6>

                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie ">
                            {!! $chart->container() !!}
                        </div>
                        <div class="mt-4 text-center small">

                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Chart --}}
            @if (Auth::user()->role == 'admin')
                <div class="col">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-dark">Tabel Pelaporan Keseluruhan Polsek</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Keterangan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($table_berkas as $item)
                                        <tr>
                                            <th scope="row" class="font-weight-bold text-dark">{{ $loop->iteration }}
                                            </th>
                                            <td class="text-dark">
                                                <span class="font-weight-bold">({{ $item->user->satker->nama }})
                                                    {{ $item->user->name }}
                                                </span>
                                                telah memasukkan berkas dengan Nomor
                                                @if ($item->status_id == 1)
                                                    <a href="{{ route('dokumen.berkas.tertunda') }}">
                                                        <span
                                                            class="font-weight-bold text-primary">{{ $item->nomor_berkas }}
                                                        </span>
                                                    </a>
                                                @elseif($item->status_id == 4)
                                                    <a href="{{ route('dokumen.berkas.ditolak') }}">
                                                        <span
                                                            class="font-weight-bold text-primary">{{ $item->nomor_berkas }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('dokumen.berkas') }}">
                                                        <span
                                                            class="font-weight-bold text-primary">{{ $item->nomor_berkas }}
                                                        </span>
                                                    </a>
                                                @endif

                                                <p style="font-size: 12px" class="text-secondary">
                                                    <span
                                                        class="badge badge-secondary">{{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if (Auth::user()->role == 'user')
                <div class="col">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-dark">Tabel Pelaporan Keseluruhan Polsek</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Keterangan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($table_berkas as $item)
                                        <tr>
                                            <th scope="row" class="font-weight-bold text-dark">{{ $loop->iteration }}
                                            </th>
                                            <td class="text-dark">
                                                <span class="font-weight-bold">({{ $item->user->satker->nama }})
                                                    {{ $item->user->name }}
                                                </span>
                                                telah memasukkan berkas dengan Nomor
                                                <span
                                                    class="font-weight-bold text-primary">{{ $item->nomor_berkas }}</span>
                                                <p style="font-size: 12px" class="text-secondary">
                                                    <span
                                                        class="badge badge-secondary">{{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@section('footer-js')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
        var total_berkas = {!! json_encode($total_berkas) !!};
        var bulan = {!! json_encode($bulan) !!};
        Highcharts.chart('grafik', {
            title: {
                text: 'Polres Minahasa'
            },
            xAxis: {
                categories: bulan
            },
            yAxis: {
                title: {
                    text: 'Jumlah Berkas'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Total Berkas',
                data: total_berkas
            }]
        });
    </script>
@endsection
