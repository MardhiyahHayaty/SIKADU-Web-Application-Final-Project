@extends('layouts.petugas')
@section('title','List Data Pemadaman Listrik')

@php
use Illuminate\Support\Str;
@endphp
@section('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Ensure jQuery is loaded first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Then Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    .status-berlangsung,
    .status-selesai,
    .status-mendatang {
        border: none;
        padding: 3px 2px;
        border-radius: 5px;
        background-color: inherit;
        font-size: 10px;
        font-weight: bold;
        /* Use background-color property to apply specific color */
    }

    .status-berlangsung {
        background-color: #b9fac5;
        color: #0ba327;
        /* Warna biru */
    }

    .status-selesai {
        background-color: #b6e1fc;
        color: #047ccc;
        /* Warna hijau */
    }

    .status-mendatang {
        background-color: #e3e5e8;
        color: #717f80;
        /* Warna abu-abu */
    }

    .fixed-width {
        width: 80px;
        /* Tentukan lebar yang sesuai */
        display: inline-block;
        text-align: center;
    }

    .control-label {
        margin-top: 12px;
    }

    .btn-primary-pemadaman {
        color: #fff;
        width: 100px;
        border: none;
        border-radius: 5px;
        background-color: #008080;
    }

    .btn-primary-pemadaman:hover {
        color: #ffffff;
        background-color: #339999;
    }

</style>
@endsection
@section('judul_header', 'Data Pemadaman Listrik')
</head>

<body>
    @section('content')
    <div class="row">
        <!--begin::Search bar-->
        <div class="col-md-10">
            <div class="form-group">
                <!--<input type="search" class="form-control" id="search" name="search" placeholder="Cari Data Pemadaman Listrik" style="width: 50%; margin-left: 30px" />-->
            </div>
        </div>
        <div class="col-md-2">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post" style="margin-right: 17%;">Tambah</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead style="font-weight: bold; font-size: 12px;">
                                <tr>
                                    <th style="width: 1%;"></th>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Petugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-pemadamans" style="font-size: 12px;">
                                @php
                                    // Hitung nomor urut berdasarkan halaman saat ini dan iterasi
                                    $currentPage = $pemadamans->currentPage();
                                    $itemsPerPage = $pemadamans->perPage();
                                    $startingNumber = ($currentPage - 1) * $itemsPerPage + 1;
                                @endphp
                                @foreach($pemadamans as $pemadaman)
                                <tr id="index_{{ $pemadaman->id }}">
                                    <td></td>
                                    <td>{{ $loop->iteration + $startingNumber - 1 }}</td>
                                    <td>{{ $pemadaman-> judul_pemadaman }}</td>
                                    <td>{{ date("d-m-Y", strtotime($pemadaman-> tgl_mulai_pemadaman)) }}</td>
                                    <td>{{ date("H:i", strtotime($pemadaman-> jam_mulai_pemadaman)) }}</td>
                                    <td>{{ date("H:i", strtotime($pemadaman-> jam_selesai_pemadaman)) }}</td>
                                    <td>{{ $pemadaman-> lokasi_pemadaman }}</td>
                                    <td>
                                        @if ($pemadaman-> status_pemadaman == 'Mendatang')
                                        <a class="status-mendatang fixed-width">Mendatang</a>
                                        @elseif ($pemadaman-> status_pemadaman == 'Berlangsung')
                                        <a class="status-berlangsung fixed-width">Berlangsung</a>
                                        @elseif ($pemadaman-> status_pemadaman == 'Selesai')
                                        <a class="status-selesai fixed-width">Selesai</a>
                                        @endif
                                    </td>
                                    <td>{{ $pemadaman-> petugas->nama_petugas }}</td>
                                    <td class="text-left">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $pemadaman->id }}" class="btn btn-primary btn-sm" style="padding: 6px;">
                                            <img alt="icon" src="assets/media/icons/edit.png" style="width: 16px; height: 16px;">
                                        </a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $pemadaman->id }}" class="btn btn-danger btn-sm" style="padding: 6px;">
                                            <img alt="icon" src="assets/media/icons/delete.png" style="width: 16px; height: 16px;">
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <p>Showing {{ $pemadamans->firstItem() }} to {{ $pemadamans->lastItem() }} of {{ $pemadamans->total() }} data</p>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-end">
                                    {!! $pemadamans->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pemadaman.modal-create')
    @include('pemadaman.update')
    @include('pemadaman.delete')
    @endsection
</body>

</html>