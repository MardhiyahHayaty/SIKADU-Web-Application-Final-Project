@extends('layouts.petugas')
@section('title','List Data Berita')

@php
    use Illuminate\Support\Str;
@endphp
    @section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <style>
        .control-label {
        margin-top: 12px;
    }

    .btn-primary-berita {
        color: #fff;
        width: 100px;
        border: none;
        border-radius: 5px;
        background-color: #008080;
    }

    .btn-primary-berita:hover {
        color: #ffffff;
        background-color: #339999;
    }
    </style>

    @endsection
    @section('judul_header', 'Data Berita') 
</head>

<body>
    @section('content')
    <div class="row">
        <!--begin::Search bar-->
        <div class="col-md-10">
            <div class="form-group">
                <input type="search" class="form-control" id="search" name="search" placeholder="Cari Data Berita" style="width: 50%; margin-left: 30px"/>
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
                                <th style="width: 20%;">Judul</th>
                                <th style="width: 40%;">Isi</th>
                                <th>Foto</th>
                                <th>Tanggal Terbit</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-beritas" style="font-size: 12px;">
                            @php
                                // Hitung nomor urut berdasarkan halaman saat ini dan iterasi
                                $currentPage = $beritas->currentPage();
                                $itemsPerPage = $beritas->perPage();
                                $startingNumber = ($currentPage - 1) * $itemsPerPage + 1;
                            @endphp
                            @foreach($beritas as $berita)
                            <tr id="index_{{ $berita->id }}">
                                <td></td>
                                <td>{{ $loop->iteration + $startingNumber - 1 }}</td>
                                <td>{{ $berita-> judul_berita }}</td>
                                <td>{{ Str::limit($berita-> isi_berita, 250) }}</td>
                                <td>
                                    <a href="{{url('storage/berita/'.$berita->foto_berita)}}" data-lightbox="image-1" data-title="Foto Berita">
                                        <img src="{{url('storage/berita/'.$berita->foto_berita)}}" width="30" height="30">
                                    </a>
                                </td>
                                <td>{{ date("d-m-Y  H:i", strtotime($berita-> tgl_terbit_berita)) }}</td>
                                <td>{{ $berita-> petugas -> nama_petugas }}</td>
                                <td class="text-left">
                                    <a href="javascript:void(0)"id="btn-edit-post" data-id="{{ $berita->id }}" class="btn btn-primary btn-sm" style="padding: 6px;">
                                        <img alt="icon" src="assets/media/icons/edit.png" style="width: 16px; height: 16px;">
                                    </a>
                                    <a href="javascript:void(0)"id="btn-delete-post" data-id="{{ $berita->id }}" class="btn btn-danger btn-sm" style="padding: 6px;">
                                        <img alt="icon" src="assets/media/icons/delete.png" style="width: 16px; height: 16px;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <p>Showing {{ $beritas->firstItem() }} to {{ $beritas->lastItem() }} of {{ $beritas->total() }} data</p>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-end">
                                {!! $beritas->links() !!}
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@include('berita.modal-create')
@include('berita.update')
@include('berita.delete')
@endsection
</body>
</html>