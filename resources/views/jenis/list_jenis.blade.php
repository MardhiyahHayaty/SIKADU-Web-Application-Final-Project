@extends('layouts.petugas')
@section('title','List Data Kategori Aduan')

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

    .btn-primary-jenis {
        color: #fff;
        width: 100px;
        border: none;
        border-radius: 5px;
        background-color: #008080;
    }

    .btn-primary-jenis:hover {
        color: #ffffff;
        background-color: #339999;
    }
    </style>

    @endsection
    @section('judul_header', 'Data Kategori Aduan') 
</head>

<body>
    @section('content')
    <div class="row">
        <!--begin::Search bar-->
        <div class="col-md-10">
            <div class="form-group">
                <!--<input type="search" class="form-control" id="search" name="search" placeholder="Cari Data Kategori / Jenis Aduan" style="width: 50%; margin-left: 30px"/>-->
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
                                    <th>Kategori Aduan</th>
                                    <th>Jenis Aduan</th>
                                    <th>Nama OPD</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-jenisa" style="font-size: 12px;">
                                @php
                                    // Hitung nomor urut berdasarkan halaman saat ini dan iterasi
                                    $currentPage = $jenisa->currentPage();
                                    $itemsPerPage = $jenisa->perPage();
                                    $startingNumber = ($currentPage - 1) * $itemsPerPage + 1;
                                @endphp
                                @foreach($jenisa as $jenis)
                                <tr id="index_{{ $jenis->id }}">
                                    <td></td>
                                    <td>{{ $loop->iteration + $startingNumber - 1 }}</td>
                                    <td>{{ $jenis-> kategori -> nama_kategori }}</td>
                                    <td>{{ $jenis-> nama_jenis_aduan }}</td>
                                    <td>{{ $jenis-> opd -> nama_opd }}</td>
                                    <td>
                                        <a href="{{url('storage/jenis/'.$jenis->foto_jenis_aduan)}}" data-lightbox="image-1" data-title="Foto Jenis Aduan">
                                            <img src="{{url('storage/jenis/'.$jenis->foto_jenis_aduan)}}" width="30" height="30">
                                        </a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:void(0)"id="btn-edit-post" data-id="{{ $jenis->id }}" class="btn btn-primary btn-sm" style="padding: 6px;">
                                            <img alt="icon" src="assets/media/icons/edit.png" style="width: 16px; height: 16px;">
                                        </a>
                                        <a href="javascript:void(0)"id="btn-delete-post" data-id="{{ $jenis->id }}" class="btn btn-danger btn-sm" style="padding: 6px;">
                                            <img alt="icon" src="assets/media/icons/delete.png" style="width: 16px; height: 16px;">
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <p>Showing {{ $jenisa->firstItem() }} to {{ $jenisa->lastItem() }} of {{ $jenisa->total() }} data</p>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-end">
                                    {!! $jenisa->links() !!}
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">   
    
</script>
@include('jenis.modal-create')
@include('jenis.update')
@include('jenis.delete')
@include('jenis.add-kategori')
@endsection
</body>
</html>