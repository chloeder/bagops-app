@extends('layouts.main')
@section('content')
    {{-- Content --}}
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Berkas</h1>
        <p class="mb-4">Berikut adalah daftar Berkas yang telah Tertunda, Menunggu persetujuan dari Petugas</p>
        <div class="single-work wow fadeInUp text-start" data-wow-delay=".2s">
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Berkas</h6>
            </div>
            <div class="card-body">
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session()->get('status') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No Berkas</th>
                                <th>Kategori</th>
                                <th>Dimasukkan</th>
                                <th>Penginput</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No Berkas</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Penginput</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($berkas as $item)
                                <tr>
                                    @if ($item->status_id == 1)
                                        <td>{{ $item->nomor_berkas }}</td>
                                        <td>{{ $item->category->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->status->nama }}</td>

                                        <td>
                                            <div class="d-inline-flex">
                                                <form action="{{ route('update.status.diterima', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" onclick="return confirm('Are You sure?')"
                                                        class="btn btn-sm btn-success mr-1">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('update.status.terlambat', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" onclick="return confirm('Are You sure?')"
                                                        class="btn btn-sm btn-danger ml-1">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
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
