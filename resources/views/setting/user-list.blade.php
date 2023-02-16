@extends('layouts.main')
@section('content')
    {{-- Content --}}
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">User Managament</h1>
        <p class="mb-4">Berikut adalah daftar User yang telah melakukan Registrasi</p>
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
                <h6 class="m-0 font-weight-bold text-primary">List Berkas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>

                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if ($item->status == 'inactive')
                                            <form action="{{ route('update.status.user', $item->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn btn-sm btn-danger">Inactive</button>
                                            </form>
                                        @else
                                            <form action="{{ route('update.status.user', $item->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn btn-sm btn-success">Active</button>
                                            </form>
                                        @endif
                                    </td>

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

    {{-- Modal Trigger --}}
    {{-- @foreach ($berkas as $item)
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
                            <span>{{ $item->user->name }}</span>
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">Status :</label>
                            @if ($item->status_id == 1)
                                <td>
                                    <span class="text-warning">{{ $item->status->nama }}</span>
                                </td>
                            @elseif($item->status_id == 2)
                                <td>
                                    <span class="text-success">{{ $item->status->nama }}</span>
                                </td>
                            @else
                                <td>
                                    <span class="text-danger">{{ $item->status->nama }}</span>
                                </td>
                            @endif
                        </div>
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">File :</label>
                            <span>{{ $item->file }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}
    {{-- End Model Trigger --}}
@endsection
