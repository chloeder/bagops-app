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
                                <th>File</th>
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
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($berkas as $item)
                                <tr>
                                    @if ($item->status_id == 1)
                                        <td class="align-middle">{{ $item->nomor_berkas }}</td>
                                        <td class="align-middle">{{ $item->category->nama }}</td>
                                        <td class="align-middle">
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                        <td class="align-middle">{{ $item->file }}</td>
                                        <td class="align-middle"><span
                                                class="badge badge-info">{{ $item->status->nama }}</span></td>

                                        <td>
                                            {{-- <form action="/dokumen/detail/{{ $item->slug }}" method="post"
                                                class="form d-flex">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group mb-3">
                                                    <select class="form-select" id="status_type" name="status_type">
                                                        @foreach ($status as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                        @endforeach
                                                    </select>

                                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                                        Update
                                                    </button>
                                            </form> --}}
                                            <div class="card-body">
                                                <form action="/update/status/{{ $item->id }}" method="post"
                                                    class="form d-flex">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="status_id">Options</label>
                                                        <select class="form-select" id="status_id" name="status_id">
                                                            @foreach ($status as $s)
                                                                <option value="{{ $s->id }}"
                                                                    @if ($s->id == '') selected='selected' @endif>
                                                                    {{ $s->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <button type="submit" class="btn btn-sm btn-primary me-1 mb-1">
                                                            Update
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
