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
                                <th>Nama Penginput</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($berkas as $item)
                                <tr>
                                    @if ($item->status_id == 4)
                                        <td class="align-middle"><span
                                                class="badge badge-dark">{{ $item->nomor_berkas }}</span></td>
                                        <td class="align-middle">
                                            <span
                                                class="badge badge-danger">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d-F-Y H:i:s') }}</span>
                                        </td>
                                        <td class="align-middle">{{ $item->category->nama }}</td>
                                        <td class="align-middle">{{ $item->user->name }} ({{ $item->user->satker->nama }})
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-danger">{{ $item->status->nama }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-sm btn-info me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detailberkas-{{ $item->id }}">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
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
                        <hr>
                        <div class="mt-5 mb-2">
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
                            <span>{{ $item->user->name }} ({{ $item->user->satker->nama }})</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">Status :</label>
                            <td>
                                <span class="badge badge-danger">{{ $item->status->nama }}</span>
                            </td>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">File :</label>
                            <a href="{{ route('dokumen.download', $item->id) }}">
                                <button type="button" class="btn btn-sm btn-success">Download</button>
                            </a>
                            <p style="font-size: 15px" class="text-danger">*Berkas tidak memenuhi syarat</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Model Trigger Detail --}}
@endsection
