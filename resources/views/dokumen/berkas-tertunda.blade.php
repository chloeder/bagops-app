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
                <h6 class="m-0 font-weight-bold text-dark">List Berkas</h6>
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
                                <th>File</th>
                                <th>Nama Penginput</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No Berkas</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>File</th>
                                <th>Nama Penginput</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($berkas as $item)
                                <tr>
                                    @if ($item->status_id == 1)
                                        <td class="align-middle"><span
                                                class="badge badge-dark">{{ $item->nomor_berkas }}</span></td>
                                        <td class="align-middle">
                                            <span
                                                class="badge badge-info">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d-F-Y H:i:s') }}</span>
                                        </td>
                                        <td class="align-middle">{{ $item->category->nama }}</td>
                                        <td class="align-middle"> <a href="{{ route('dokumen.download', $item->id) }}"
                                                type="button" class="btn btn-sm btn-success">
                                                <i class="bi bi-download"></i>
                                            </a></td>
                                        <td class="align-middle">
                                            {{ $item->user->name }} ({{ $item->user->satker->nama }})
                                        </td>
                                        <td class="align-middle"><span
                                                class="badge badge-info">{{ $item->status->nama }}</span></td>

                                        <td>
                                            <div class="d-flex">
                                                <form action="{{ route('update.status.dokumen', $item->id) }}"
                                                    method="post" class="form d-flex">
                                                    @csrf
                                                    @method('PUT')
                                                    <select class="btn btn-sm btn-dark" aria-label="Default select example"
                                                        id="status_id" name="status_id" onchange="getOption()">
                                                        <option selected>Pilih Disini</option>
                                                        @foreach ($status as $s)
                                                            <option value="{{ $s->id }}">
                                                                {{ $s->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="submit" value="Update"
                                                        class="btn btn-sm btn-primary ms-2">
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
