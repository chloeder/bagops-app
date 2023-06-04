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
                                <th>Judul</th>
                                <th>Kategori</th>
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
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal"
                                                data-bs-target="#detailberkas-{{ $item->id }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
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


    {{-- Modal Trigger Detail --}}
    @foreach ($berkas as $item)
        <div class="modal fade" id="detailberkas-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailberkas-{{ $item->id }}" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg mx-0 mx-sm-auto">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="berkasLabel">Detail Berkas</h5>
                        <button type="button" onClick="window.location.reload();" class="btn-close text-white"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <p>
                                Berikut adalah Detail dari Berkas Nomor <strong>{{ $item->nomor_berkas }}</strong>
                            </p>
                        </div>
                        <hr class="border-1">

                        <div class="mt-3 mb-2">
                            <label for="judul" name="nomor_berkas" class="mb-2 fw-bolder">Nomor Berkas :</label>
                            <span>{{ $item->nomor_berkas }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">Judul :</label>
                            <span>{{ $item->judul }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="category_id" class="mb-2 fw-bolder">Kategori :</label>
                            <span>{{ $item->category->nama }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="keterangan" class="mb-2 fw-bolder">Keterangan :</label>
                            <span>{{ $item->keterangan }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">Tanggal Dimasukkan :</label>
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">Petugas yang Memasukkan :</label>
                            <span>{{ $item->user->name }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">Status :</label>
                            @if ($item->status_id == 2)
                                <td class="align-middle">
                                    <span class="badge badge-success">{{ $item->status->nama }}</span>
                                </td>
                            @else
                                <td class="align-middle">
                                    <span class="badge badge-warning">{{ $item->status->nama }}</span>
                                </td>
                            @endif
                        </div>
                        <label for="judul" name="judul" class="mb-2 fw-bolder">Lampiran File :</label>
                        <div class=" mb-2 text-center">
                            <iframe src="{{ asset('/storage/berkas/' . $item->file) }}" frameborder="10" width="600"
                                height="600"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Model Trigger Detail --}}
@endsection
