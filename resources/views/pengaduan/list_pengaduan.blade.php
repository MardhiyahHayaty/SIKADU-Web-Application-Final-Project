@extends('layouts.petugas')
@section('title','List Data Pengaduan')

@php
use Illuminate\Support\Str;
@endphp
@section('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<style>
    .status-proses,
    .status-selesai,
    .status-belumproses,
    .status-tolak {
        border: none;
        padding: 3px 2px;
        border-radius: 5px;
        background-color: inherit;
        font-size: 10px;
        font-weight: bold;
        /* Use background-color property to apply specific color */
    }

    .status-proses {
        background-color: #b9fac5;
        color: #0ba327;
        /* Warna biru */
    }

    .status-selesai {
        background-color: #b6e1fc;
        color: #047ccc;
        /* Warna hijau */
    }

    .status-belumproses {
        background-color: #e3e5e8;
        color: #717f80;
        /* Warna abu-abu */
    }

    .status-tolak {
        background-color: #fac0bb;
        color: #cf1204;
        /* Warna merah */
    }

    .fixed-width {
        width: 80px;
        /* Tentukan lebar yang sesuai */
        display: inline-block;
        text-align: center;
    }

    .btn-filter {
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        color: #666a6d;
        background-color: #EEEEEE;
        /* Warna abu-abu */
        margin-right: 5px;
        border-radius: 8px;
    }

    .btn-filter.active {
        background-color: #57C0C0;
        color: #fff;
        box-shadow: 0 4px 6px rgba(0, 128, 128, 0.3);
    }

    .filter-tgl {
        width: 50%;
        height: 70%;
        margin-right: 2%;
    }

    .flex-container {
        display: flex;
        align-items: center; /* Mengatur item agar berada di tengah vertikal */
        justify-content: space-between; /* Mengatur jarak antar elemen */
    }

    .flex-container .form-group {
        flex: 1; /* Menggunakan flex untuk membagi ruang secara proporsional */
        margin-right: 10px; /* Jarak antar elemen */
    }

    .flex-container .form-group:last-child {
        margin-right: 0; /* Menghilangkan margin kanan pada elemen terakhir */
    }

    .btn-filter-tgl {
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        color: #ffffff;
        background-color: #008080;
        /* Warna abu-abu */
        margin-right: 5px;
        margin-top: 10px;
        border-radius: 8px;
        font-family: Poppins;
    }
</style>
@endsection
@section('judul_header', 'Data Pengaduan')
</head>

<body>
    @section('content')
    <div class="row">
        <!--begin::Search bar-->
        <div class="col-md-10">
            <div class="form-group">
                <input type="search" class="form-control" id="search" name="search" placeholder="Cari Data Pengaduan" style="width: 50%; margin-left: 30px" />
            </div>
        </div>
        <div class="col-md-2">

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="row mb-3" style="margin-left: 20px; margin-top: 36px;">
                        <div class="col-md-12">
                            <div class="flex-container">
                                <div>
                                    <a href="{{ route('pengaduan.index') }}" class="btn-filter {{ request()->is('pengaduan') ? 'active' : '' }}">Semua</a>
                                    <a href="{{ route('pengaduan.filter', ['status_pengaduan' => '0']) }}" class="btn-filter {{ request()->query('status_pengaduan') == '0' ? 'active' : '' }}">Belum Proses</a>
                                    <a href="{{ route('pengaduan.filter', ['status_pengaduan' => 'proses']) }}" class="btn-filter {{ request()->query('status_pengaduan') == 'proses' ? 'active' : '' }}">Proses</a>
                                    <a href="{{ route('pengaduan.filter', ['status_pengaduan' => 'selesai']) }}" class="btn-filter {{ request()->query('status_pengaduan') == 'selesai' ? 'active' : '' }}">Selesai</a>
                                    <a href="{{ route('pengaduan.filter', ['status_pengaduan' => 'tolak']) }}" class="btn-filter {{ request()->query('status_pengaduan') == 'tolak' ? 'active' : '' }}">Tolak</a>
                                </div>
                                
                                <div class="filter-tgl">
                                <form action="{{ route('pengaduan.index') }}" method="GET">
                                    <div class="flex-container">
                                        <div class="form-group">
                                            <label for="from_date" style="font-size: 12px; margin-bottom: 2px; margin-top: -8px;">Dari Tanggal:</label>
                                            <input type="date" class="form-control" id="from_date" name="from_date" style="height: 36px; font-size: 12px; color: #666a6d;" value="{{ request()->input('from_date') }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="to_date" style="font-size: 12px; margin-bottom: 2px; margin-top: -8px;">Sampai Tanggal:</label>
                                            <input type="date" class="form-control" id="to_date" name="to_date" style="height: 36px; font-size: 12px; color: #666a6d;" value="{{ request()->input('to_date') }}" />
                                        </div>
                                        <button type="submit" class="btn-filter-tgl">Filter</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead style="font-weight: bold; font-size: 12px;">
                                <tr>
                                    <th style="width: 1%;"></th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat Email</th>
                                    <th>Kategori</th>
                                    <th style="width: 30%;">Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Detail</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="table-pengaduans" style="font-size: 12px;">
                                @php
                                // Hitung nomor urut berdasarkan halaman saat ini dan iterasi
                                $currentPage = $pengaduans->currentPage();
                                $itemsPerPage = $pengaduans->perPage();
                                $startingNumber = ($currentPage - 1) * $itemsPerPage + 1;
                                @endphp
                                @foreach($pengaduans as $pengaduan)
                                <tr id="index_{{ $pengaduan->id }}">
                                    <td></td>
                                    <td>{{ $loop->iteration + $startingNumber - 1 }}</td>
                                    <td>{{ $pengaduan-> masyarakat -> nama_masyarakat }}</td>
                                    <td>{{ $pengaduan-> masyarakat -> email}}</td>
                                    <td>{{ $pengaduan-> jenis -> nama_jenis_aduan }}</td>
                                    <td>{{ $pengaduan-> lokasi_pengaduan}}</td>
                                    <td>{{ date("d M Y", strtotime($pengaduan->tgl_pengaduan)) }}</td>
                                    <td class="text-left">
                                        <a href="{{ route('pengaduan.show', $pengaduan->id) }}" id="btn-edit-post">Lihat</a>
                                    </td>
                                    <td>
                                        @if ($pengaduan->status_pengaduan == '0')
                                        <a class="status-belumproses fixed-width">Belum Proses</a>
                                        @elseif ($pengaduan->status_pengaduan == 'proses')
                                        <a class="status-proses fixed-width">Proses</a>
                                        @elseif ($pengaduan->status_pengaduan == 'selesai')
                                        <a class="status-selesai fixed-width">Selesai</a>
                                        @elseif ($pengaduan->status_pengaduan == 'tolak')
                                        <a class="status-tolak fixed-width">Tolak</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <p>Showing {{ $pengaduans->firstItem() }} to {{ $pengaduans->lastItem() }} of {{ $pengaduans->total() }} data</p>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-end">
                                    {!! $pengaduans->links() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>