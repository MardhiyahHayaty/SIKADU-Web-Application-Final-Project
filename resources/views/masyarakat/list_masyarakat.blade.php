@extends('layouts.petugas')
@section('title','List Data Masyarakat')

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
    @endsection
    @section('judul_header', 'Data Masyarakat') 
</head>

<body>
    @section('content')
    <div class="row">
        <!--begin::Search bar-->
        <div class="col-md-10">
            <div class="form-group">
                <input type="search" class="form-control" id="search" name="search" placeholder="Cari Data Petugas" style="width: 50%; margin-left: 30px"/>
            </div>
        </div>
        <div class="col-md-2">
            
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
                                    <th>NIK</th>
                                    <th>Nama Masyarakat</th>
                                    <th>Alamat Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody id="table-masyarakat" style="font-size: 12px;">
                                @php
                                    // Hitung nomor urut berdasarkan halaman saat ini dan iterasi
                                    $currentPage = $masyarakats->currentPage();
                                    $itemsPerPage = $masyarakats->perPage();
                                    $startingNumber = ($currentPage - 1) * $itemsPerPage + 1;
                                @endphp
                                @foreach($masyarakats as $masyarakat)
                                <tr id="index_{{ $masyarakat->nik }}">
                                    <td>
                                    <td>{{ $loop->iteration + $startingNumber - 1 }}</td>
                                    <td>{{ $masyarakat-> nik }}</td>
                                    <td>{{ $masyarakat-> nama_masyarakat }}</td>
                                    <td>{{ $masyarakat-> email_masyarakat }}</td>
                                    <td>{{ $masyarakat-> telp_masyarakat }}</td>
                                    <td>
                                        <a href="{{url('storage/masyarakat/'.$masyarakat->foto_masyarakat)}}" data-lightbox="image-1" data-title="Foto Masyarakat">
                                            <img src="{{ $masyarakat->foto_masyarakat ? url('storage/masyarakat/'.$masyarakat->foto_masyarakat) : url('assets/media/icons/dummy-profile.jpg') }}" width="30" height="30">
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <p>Showing {{ $masyarakats->firstItem() }} to {{ $masyarakats->lastItem() }} of {{ $masyarakats->total() }} data</p>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-end">
                                    {!! $masyarakats->links() !!}
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
@endsection
</body>
</html>