@extends('layouts.main')
@section('content')
    {{-- Content --}}
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Berkas</h1>
        <p class="mb-4">Berikut adalah daftar Berkas yang telah Dimasukkan</p>
        @if (session()->has('delete'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('delete') }}
            </div>
        @endif
        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
        @endif
        @if (session()->has('status'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('status') }}
            </div>
        @endif
        <div class="single-work wow fadeInUp text-start" data-wow-delay=".2s">
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Berkas</h6>
            </div>
            <div class="card-body">
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

                                <input type="submit" value="Filter" class="btn btn-primary ms-4">
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No Berkas</th>
                                <th>Kategori</th>
                                <th>Dimasukkan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No Berkas</th>
                                <th>Kategori</th>
                                <th>Dimasukkan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse($berkas as $item)
                                <tr>
                                    @if ($item->status_id == 2 || $item->status_id == 3)
                                        <td class="align-middle">{{ $item->nomor_berkas }}</td>
                                        <td class="align-middle">{{ $item->category->nama }}</td>
                                        <td class="align-middle">
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                        </td>
                                        @if ($item->status_id == 2)
                                            <td class="align-middle">
                                                <span class="badge badge-success">{{ $item->status->nama }}</span>
                                            </td>
                                        @else
                                            <td class="align-middle">
                                                <span class="badge badge-warning">{{ $item->status->nama }}</span>
                                            </td>
                                        @endif

                                        <td class="align-middle">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-sm btn-info me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detailberkas-{{ $item->id }}">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editberkas-{{ $item->id }}">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <form action="{{ route('dokumen.hapus', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger me-2">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('dokumen.download', $item->id) }}" type="button"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-download"></i>
                                                </a>


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
                        <div class="mb-2">
                            <label for="judul" name="judul" class="mb-2 fw-bolder">File :</label>
                            <a href="{{ route('dokumen.download', $item->id) }}">
                                <button type="button" class="btn btn-sm btn-success">Download</button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Model Trigger Detail --}}

    {{-- Modal Trigger Update --}}
    @foreach ($berkas as $item)
        <div class="modal fade" id="editberkas-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editberkas-{{ $item->id }}" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg mx-0 mx-sm-auto">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="berkasLabel">Detail Berkas</h5>
                        <button type="button" onClick="window.location.reload();" class="btn-close text-white"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('dokumen.update', $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="text-center">
                                <p>
                                    Berikut adalah Detail dari Berkas Nomor <strong>{{ $item->nomor_berkas }}</strong>

                            </div>
                            <hr>
                            <div class="mt-5 mb-3">
                                <label for="judul" name="judul" class="mb-2 fw-bolder">Judul :</label>
                                <input type="text" class="form-control" id="recipient-name">
                                <p class="fs-6">Data Sebelumnya : <span class="text-danger">{{ $item->judul }}*</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" name="category_id" class="mb-2 fw-bolder">Kategori :</label>
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
                                <p class="fs-6">Data Sebelumnya : <span
                                        class="text-danger">{{ $item->category->nama }}*</span></p>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" name="keterangan" class="mb-2 fw-bolder">Keterangan :</label>
                                <input type="text" class="form-control" id="recipient-name">
                                <p class="fs-6">Data Sebelumnya : <span
                                        class="text-danger">{{ $item->keterangan }}*</span></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" onClick="window.location.reload();"
                                    class="btn btn-outline-primary" data-bs-dismiss="modal">
                                    Keluar
                                </button>
                                <button type="submit" class="btn btn-primary">Update Berkas</button>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="judul" name="judul" class="mb-2 fw-bolder">Tanggal Dimasukkan :</label>
                                <input type="text" class="form-control" id="recipient-name"
                                    value="{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}"
                                    readonly>

                            </div>
                            <div class="mb-3">
                                <label for="judul" name="judul" class="mb-2 fw-bolder">Petugas yang Memasukkan
                                    :</label>
                                <input type="text" class="form-control" id="recipient-name"
                                    value="{{ $item->user->name }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="judul" name="judul" class="mb-2 fw-bolder">Status :</label>
                                @if ($item->status_id == 1)
                                    <td>
                                        <input type="text" class="form-control text-warning" id="recipient-name"
                                            value="{{ $item->status->nama }}" readonly>
                                    </td>
                                @elseif($item->status_id == 2)
                                    <td>
                                        <input type="text" class="form-control text-success" id="recipient-name"
                                            value="{{ $item->status->nama }}" readonly>
                                    </td>
                                @else
                                    <td>
                                        <input type="text" class="form-control text-danger" id="recipient-name"
                                            value="{{ $item->status->nama }}" readonly>
                                    </td>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="judul" name="judul" class="mb-2 fw-bolder">File :</label>
                                <input type="text" class="form-control" id="recipient-name"
                                    value="{{ $item->file }}" readonly>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Model Trigger Update --}}
@endsection
{{-- @section('footer-js')
    <script>
        const monthControl = document.querySelector('input[type="month"]');
        const date = new Date()
        const month = ("0" + (date.getMonth() + 1)).slice(-2)
        const year = date.getFullYear()
        monthControl.value = `${year}-${month}`;
    </script>
@endsection --}}
