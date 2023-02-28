@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Berkas</h1>
        <p class="mb-4">Silahkan menambahkan Berkas sesuai dengan keperluan yang dibutuhkan</p>
        <div class="single-work wow fadeInUp text-start" data-wow-delay=".2s">
            <button type="button" class="btn btn-sm btn-primary shadow-sm mb-3" data-bs-toggle="modal"
                data-bs-target="#berkas">
                <i class="fas fa-download fa-sm text-white-150"></i> Unggah Berkas
            </button>
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
        @endif

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
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No Berkas</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($berkas as $item)
                                <tr>
                                    <td>{{ $item->nomor_berkas }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->category->nama }}</td>
                                    @if ($item->status_id == 1)
                                        <td>
                                            <span class="badge badge-info">{{ $item->status->nama }}</span>
                                            <p style="font-size: 10px" class="text-danger">*Berkas belum diproses petugas
                                            </p>
                                        </td>
                                    @elseif($item->status_id == 2)
                                        <td>
                                            <span class="badge badge-success">{{ $item->status->nama }}</span>
                                        </td>
                                    @elseif($item->status_id == 3)
                                        <td>
                                            <span class="badge badge-warning">{{ $item->status->nama }}</span>
                                            <p style="font-size: 10px" class="text-danger">*Berkas melewati batas tanggal
                                                pengumpulan</p>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge badge-danger">{{ $item->status->nama }}</span>
                                            <p style="font-size: 10px" class="text-danger">*Berkas belum memenuhi syarat</p>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Trigger --}}
    <form action="{{ route('berkas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="berkas" tabindex="-1" aria-labelledby="berkasLabel" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg mx-0 mx-sm-auto">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="berkasLabel">Form Pemasukkan Berkas</h5>
                        <button type="button" onClick="window.location.reload();" class="btn-close text-white"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="far fa-file-alt fa-4x mb-3 text-primary"></i>

                            <p>
                                Mohon di isi sesuai dengan <strong>Persyaratan Berkas</strong> yang di Tentukan
                            </p>
                        </div>

                        <hr />
                        <div class="row align-items-center g-4 mb-4">
                            <div class="col-6">
                                <label class="form-label" for="judul">Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" required
                                    oninvalid="this.setCustomValidity('Bagian ini tidak boleh kosong')"
                                    oninput="this.setCustomValidity('')">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="category">Kategori Berkas </label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                    aria-label="Default select example" id="category_id" name="category_id" required
                                    oninvalid="this.setCustomValidity('Bagian ini tidak boleh kosong')"
                                    oninput="this.setCustomValidity('')">
                                    <option selected>Pilih Disini</option>
                                    @foreach ($category as $c)
                                        @if ($c->status == 'active')
                                            <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center g-4 mb-4">
                            <div class="col">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea type="text" min="0" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                    name="keterangan" required oninvalid="this.setCustomValidity('Bagian ini tidak boleh kosong')"
                                    oninput="this.setCustomValidity('')">
                                    </textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center g-4 ">
                            <div class="col">
                                <label class="form-label" for="file">Lampiran Berkas (Dalam bentuk File :
                                    JPG/JPEG/PDF/Doc)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file" placeholder="#" multiple required
                                    oninvalid="this.setCustomValidity('Bagian ini tidak boleh kosong')"
                                    oninput="this.setCustomValidity('')">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onClick="window.location.reload();" class="btn btn-outline-primary"
                            data-bs-dismiss="modal">
                            Keluar
                        </button>
                        <button type="submit" class="btn btn-primary">Unggah Berkas</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
