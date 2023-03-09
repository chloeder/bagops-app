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
        @if (session()->has('wilayah'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('wilayah') }}
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
                                <th>Satuan Kerja</th>
                                <th>Status</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Satuan Kerja</th>
                                <th>Status</th>
                                <th>Aksi</th>

                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if ($item->satuan_kerja_id == 1)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 2)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 3)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 4)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 5)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 6)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 7)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 8)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 9)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 10)
                                            <span>{{ $item->satker->nama }}</span>
                                        @elseif($item->satuan_kerja_id == 11)
                                            <span>{{ $item->satker->nama }}</span>
                                        @else
                                            <span>{{ $item->satker->nama }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 'inactive')
                                            <form action="{{ route('update.status.user', $item->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="badge badge-danger"
                                                    style="border: none">Inactive</button>
                                            </form>
                                        @else
                                            <form action="{{ route('update.status.user', $item->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="badge badge-success"
                                                    style="border: none">Active</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="{{ route('update.wilayah.user', $item->id) }}" method="post"
                                                class="form d-flex">
                                                @csrf
                                                @method('PUT')
                                                <select class="btn btn-sm btn-dark" aria-label="Default select example"
                                                    id="satuan_kerja_id" name="satuan_kerja_id" onchange="getOption()">
                                                    <option selected>Pilih Satuan Kerja</option>
                                                    @foreach ($satker as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="submit" value="Update" class="btn btn-sm btn-primary ms-2">
                                            </form>
                                        </div>
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
    {{-- @foreach ($user as $item)
        <div class="modal fade" id="editberkas-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editberkas-{{ $item->id }}" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg mx-0 mx-sm-auto">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="berkasLabel">Ubah Password</h5>
                        <button type="button" onClick="window.location.reload();" class="btn-close text-white"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Password Baru</label>
                                <input type="text" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Konfirmasi Password</label>
                                <input type="text" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onClick="window.location.reload();" class="btn btn-outline-dark"
                            data-bs-dismiss="modal">
                            Keluar
                        </button>
                        <button type="submit" class="btn btn-dark">Update</button>
                    </div>
                </div>
            </div>
    @endforeach --}}
    {{-- End Model Trigger --}}
@endsection
