@extends('layouts.petugas')
@section('title','List Data FAQ')

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
    @section('judul_header', 'Data FAQ') 
</head>

<body>
    @section('content')
    <div class="row">
        <!--begin::Search bar-->
        <div class="col-md-10">
            <div class="form-group">
                <!--<input type="search" class="form-control" id="search" name="search" placeholder="Cari Data FAQ" style="width: 50%; margin-left: 30px"/>-->
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
                                <th style="width: 35%;">Pertanyaan</th>
                                <th style="width: 45%;">Jawaban</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-faqs" style="font-size: 12px;">
                            @php
                                // Hitung nomor urut berdasarkan halaman saat ini dan iterasi
                                $currentPage = $faqs->currentPage();
                                $itemsPerPage = $faqs->perPage();
                                $startingNumber = ($currentPage - 1) * $itemsPerPage + 1;
                            @endphp
                            @foreach($faqs as $faq)
                            <tr id="index_{{ $faq->id }}">
                                <td></td>
                                <td>{{ $loop->iteration + $startingNumber - 1 }}</td>
                                <td>{{ $faq-> pertanyaan }}</td>
                                <td>{{ Str::limit($faq-> jawaban, 250) }}</td>
                                <td class="text-left">
                                    <a href="javascript:void(0)"id="btn-edit-faq" data-id="{{ $faq->id }}" class="btn btn-primary btn-sm" style="padding: 6px;">
                                        <img alt="icon" src="assets/media/icons/edit.png" style="width: 16px; height: 16px;">
                                    </a>
                                    <a href="javascript:void(0)"id="btn-delete-faq" data-id="{{ $faq->id }}" class="btn btn-danger btn-sm" style="padding: 6px;">
                                        <img alt="icon" src="assets/media/icons/delete.png" style="width: 16px; height: 16px;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <p>Showing {{ $faqs->firstItem() }} to {{ $faqs->lastItem() }} of {{ $faqs->total() }} data</p>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-end">
                                {!! $faqs->links() !!}
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@include('faq.modal-create')
@include('faq.update')
@include('faq.delete')
@endsection
</body>
</html>