@extends('layouts.main')
@section('content')
    {{-- Content --}}
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Berkas</h1>
        <p class="mb-4">Berikut adalah daftar yang terlambat memasukkan Berkas</p>
        <div class="single-work wow fadeInUp text-start" data-wow-delay=".2s">
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Berkas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No Berkas</th>
                                <th>Kategori</th>
                                <th>Dimasukkan</th>
                                <th>Penginput</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No Berkas</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Penginput</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($berkas as $item)
                                <tr>
                                    @if ($item->status_id == 3)
                                        <td>{{ $item->nomor_berkas }}</td>
                                        <td>{{ $item->category->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td><span class="text-danger">{{ $item->status->nama }}</span></td>
                                    @else
                                    @endif
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
