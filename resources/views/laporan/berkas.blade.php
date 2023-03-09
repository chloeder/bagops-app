@extends('layouts.main')
@section('css-date')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@endsection
@section('content')
    {{-- Content --}}
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Laporan Berkas</h1>
        <p class="mb-4">Berikut adalah daftar Berkas Laporan berkas setiap bulannya</p>
        <div class="single-work wow fadeInUp text-start" data-wow-delay=".2s">
        </div>
        @if (session()->has('status'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('status') }}
            </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">List Berkas</h6>
            </div>
            <div class="card-body">
                {{-- <h5 class="fw-bold" style="color: black">Filter</h5> --}}
                <form action="#" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <label for="tgl_awal">Pilih Tanggal Awal</label>
                            <input type="date" value="{{ \Carbon\Carbon::now() }}" name="tgl_awal" id="tgl_awal"
                                class="form-control" placeholder="" required>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            <label for="tgl_akhir">Pilih Tanggal Akhir</label>
                            <div class="d-flex">
                                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>

                                <input type="submit" value="Filter" class="btn btn-dark ms-4">
                            </div>
                        </div>
                    </div>
                </form>
                <hr class="solid ">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No Berkas</th>
                                <th>Status</th>
                                <th>Tgl Masuk</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Nama Penginput</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No Berkas</th>
                                <th>Status</th>
                                <th>Tgl Masuk</th>
                                <th>Keterangan</th>
                                <th>Kategori</th>
                                <th>Nama Penginput</th>

                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($berkas as $item)
                                <tr>
                                    <td><span class="badge badge-dark">{{ $item->nomor_berkas }}</span>
                                    </td>
                                    @if ($item->status_id == 1)
                                        <td class="align-middle">
                                            <span class="badge badge-info">{{ $item->status->nama }}</span>
                                            <p style="font-size: 10px" class="text-danger">*Berkas belum diproses petugas
                                            </p>
                                        </td>
                                    @elseif($item->status_id == 2)
                                        <td class="align-middle">
                                            <span class="badge badge-success">{{ $item->status->nama }}</span>
                                        </td>
                                    @elseif($item->status_id == 3)
                                        <td class="align-middle">
                                            <span class="badge badge-warning">{{ $item->status->nama }}</span>
                                            <p style="font-size: 10px" class="text-danger">*Berkas melewati batas tanggal
                                                pengumpulan</p>
                                        </td>
                                    @else
                                        <td class="align-middle">
                                            <span class="badge badge-danger">{{ $item->status->nama }}</span>
                                            <p style="font-size: 10px" class="text-danger">*Berkas belum memenuhi syarat</p>
                                        </td>
                                    @endif
                                    <td>
                                        @if ($item->status_id == 1)
                                            <span
                                                class="badge badge-info">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d-F-Y H:i:s') }}</span>
                                        @elseif($item->status_id == 2)
                                            <span
                                                class="badge badge-success">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d-F-Y H:i:s') }}</span>
                                        @elseif($item->status_id == 3)
                                            <span
                                                class="badge badge-warning">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d-F-Y H:i:s') }}</span>
                                        @else
                                            <span
                                                class="badge badge-danger">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d-F-Y H:i:s') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->category->nama }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->user->name }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    {{-- End Content --}}
@endsection
