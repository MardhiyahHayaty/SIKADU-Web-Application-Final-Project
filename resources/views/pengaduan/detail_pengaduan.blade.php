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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<style>
    .flex-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .flex-container .form-group {
        flex: 1;
        min-width: 150px;
        /* optional, to ensure a minimum width */
    }

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
        /* Warna hijau */
    }

    .status-selesai {
        background-color: #b6e1fc;
        color: #047ccc;
        /* Warna biru */
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

    .control-label {
        margin-bottom: 4px;
        margin-top: 12px;
    }

    .breadcrumb-container {
        margin-bottom: 10px;
    }

    .breadcrumb {
        margin-top: 10px;
        margin-bottom: 0;
        padding: 0;
        background-color: transparent;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: '•';
        color: #6c757d;
    }

    .btn-primary-tanggapan {
        color: #fff;
        width: 100%;
        border: none;
        border-radius: 5px;
        background-color: #008080;
        margin-top: 20px;
    }

    .btn-primary-tanggapan:hover {
        color: #ffffff;
        background-color: #339999;
    }

    /* Add styles for the history */
    .flex-container-histori {
        display: flex;
        justify-content: space-between;
        /* Untuk memberikan jarak antar elemen */
        align-items: center;
        /* Untuk mengatur posisi vertikal elemen di tengah */
    }

    .timeline {
        /*background: white;*/
        padding: 6px;
        border-radius: 10px;
        /*box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);*/
        width: 430px;
        margin-top: 16px;
    }

    .entry {
        border-left: 3px solid #ccc;
        padding-left: 10px;
        margin-bottom: 20px;
        position: relative;
    }

    .entry:last-child {
        margin-bottom: 0;
    }

    .entry::before {
        content: '';
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ccc;
        position: absolute;
        left: -7px;
        top: 0;
    }

    .entry.active::before,
    .entry.active {
        /*background: #2a9d8f;*/
        border-color: #2a9d8f;
        color: #2a9d8f;
    }

    .entry.active::before {
        background: #2a9d8f;
    }

    .time {
        color: #999;
    }

    .status {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .detail {
        color: #333;
        margin-bottom: 6px;
    }

    .bukti a {
        color: #008080;
    }

    /*end of history*/

    #map {
        width: 100%;
        height: 200px;
    }
</style>
@endsection
@section('judul_header')
<div class="breadcrumb-container">
    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Detail Pengaduan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}" style="font-size: 12px; color: rgba(0, 0, 0, 0.5); font-weight: 10px;">Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="font-size: 12px; color: rgba(0, 0, 0, 0.5); font-weight: 10px;">Detail Pengaduan</li>
        </ol>
    </nav>
</div>
@endsection
</head>

<body>
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        <h4>Detail Pengaduan</h4>
                        <form id="formData_edit" enctype="multipart/form-data" method="post">
                            <input type="hidden" id="post_id">
                            <div class="flex-container">
                                <div class="form-group">
                                    <label for="name" class="control-label">Nomor Pengaduan</label>
                                    <input type="text" class="form-control" id="id-edit" name="id-edit" value="{{ $pengaduans->id }}" style="background-color: #EFF2F5;" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label">Email</label>
                                    <input type="email" class="form-control" id="email_masyarakat-edit" value="{{ $pengaduans-> masyarakat -> email_masyarakat }}" style="background-color: #EFF2F5;" readonly>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="name" class="control-label">Tanggal Pengaduan</label>
                                <input type="text" class="form-control" id="tgl_pengaduan-edit" value="{{ date('d M Y | H.i', strtotime($pengaduans->tgl_pengaduan)) }} WIB" style="background-color: #EFF2F5;" readonly>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Kategori Pengaduan</label>
                                <input type="text" class="form-control" id="nama_jenis_aduan-edit" value="{{ $pengaduans->jenis->nama_jenis_aduan }}" style="background-color: #EFF2F5;" readonly>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label">Permasalahan</label>
                                <input type="text" class="form-control" id="permasalahan-edit" value="{{ $pengaduans->permasalahan }}" style="background-color: #EFF2F5;" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan-edit" value="{{ $pengaduans->keterangan }}" style="background-color: #EFF2F5;" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi_pengaduan-edit" value="{{ $locationName }}" style="background-color: #EFF2F5;" readonly>
                            </div><br>
                            <div id="map"></div>
                            <div class="flex-container">
                                <div class="form-group">
                                    <label for="name" class="control-label">Foto</label><br>
                                    <a href="{{url('storage/pengaduan/'.$pengaduans->foto_pengaduan)}}" data-lightbox="image-1" data-title="Foto Pengaduan">
                                        <img src="{{url('storage/pengaduan/'.$pengaduans->foto_pengaduan)}}" style="width:80; height:80; border-radius:10px;">
                                    </a>

                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label">Status</label><br>
                                    @if ($pengaduans->status_pengaduan == '0')
                                    <a id="status_pengaduan" class="status-belumproses fixed-width">Belum Proses</a>
                                    @elseif ($pengaduans->status_pengaduan == 'proses')
                                    <a id="status_pengaduan" class="status-proses fixed-width">Proses</a>
                                    @elseif ($pengaduans->status_pengaduan == 'selesai')
                                    <a id="status_pengaduan" class="status-selesai fixed-width">Selesai</a>
                                    @elseif ($pengaduans->status_pengaduan == 'tolak')
                                    <a id="status_pengaduan" class="status-tolak fixed-width">Tolak</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        <h4>Tanggapan Petugas</h4>
                        <form id="formData">
                            <input type="hidden" name="id_pengaduan" value="{{ $pengaduans->id }}">
                            <div class="form-group">
                                <label for="status_pengaduan" class="control-label">Status <span class="text-danger">*</span> </label>
                                <select class="form-control" id="status_pengaduan" name="status_pengaduan">
                                    <option value="">--Pilih Status Pengaduan--</option>
                                    <option value="0" {{ $pengaduans->status_pengaduan == '0' ? 'selected' : '' }}>Belum Proses</option>
                                    <option value="proses" {{ $pengaduans->status_pengaduan == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai" {{ $pengaduans->status_pengaduan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="tolak" {{ $pengaduans->status_pengaduan == 'tolak' ? 'selected' : '' }}>Tolak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="isi_tanggapan" class="control-label">Tanggapan <span class="text-danger">*</span> </label>
                                <textarea class="form-control" id="isi_tanggapan" name="isi_tanggapan" placeholder="Belum ada tanggapan">{{ $tanggapans->isi_tanggapan ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="foto_tanggapan" class="control-label">Foto Tanggapan <span class="text-danger">*</span> </label>
                                <input type="file" class="form-control" id="foto_tanggapan" name="foto_tanggapan">
                                @if(isset($tanggapans->foto_tanggapan))
                                <a href="{{url('storage/tanggapan/'.$tanggapans->foto_tanggapan)}}" data-lightbox="image-1" data-title="Foto Tanggapan">
                                    <img id="foto_tanggapan_preview" src="{{ asset('storage/tanggapan/'.$tanggapans->foto_tanggapan) }}" alt="Pratinjau Foto Tanggapan" style="max-width: 100px; border-radius: 4px; margin-top: 2%; display: block;">
                                </a>
                                @else
                                <img id="foto_tanggapan_preview" alt="Pratinjau Foto Tanggapan" style="max-width: 160px; display: none;">
                                @endif
                            </div>
                            <button class="btn btn-primary-tanggapan" id="store">Kirim</button>
                            <div id="form-alert" style="display: none; margin-top: 10px;"></div>
                        </form>

                        <br>
                        <h4>Histori Tanggapan</h4>
                        <div class="timeline">
                            @foreach($logTanggapans as $log)
                            <div class="entry active">
                                <div class="flex-container-histori">
                                    <div class="status">{{ $log->status_tanggapan }}</div>
                                    <div class="time">{{ \Carbon\Carbon::parse($log->tgl_tanggapan)->format('d F Y | H.i') }}</div>
                                </div>
                                <div class="detail">{{ $log->isi_tanggapan }}</div>
                                <div class="bukti">
                                    @if($log->foto_tanggapan)
                                    <a href="{{ asset('storage/tanggapan/'.$log->foto_tanggapan) }}" data-lightbox="image-1" data-title="Foto Tanggapan">Lihat Foto Tanggapan</a>
                                    @else
                                    Tidak ada foto tersedia
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            <div class="entry active">
                                <div class="flex-container-histori">
                                    <div class="status">Belum Proses</div>
                                    <div class="time">{{ \Carbon\Carbon::parse($pengaduans->tgl_pengaduan)->format('d F Y | H.i') }}</div>
                                </div>
                                <div class="detail">Pengaduan masuk</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var latitude = {{$latitude}};
            var longitude = {{$longitude}};
            var map = L.map('map').setView([latitude, longitude], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('{{ $locationName }}')
                .openPopup();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#foto_tanggapan').on('change', function() {
                const [file] = this.files;
                if (file) {
                    $('#foto_tanggapan_preview').attr('src', URL.createObjectURL(file)).show();
                }
            });

            $('#formData').unbind().submit(function(event) {
                event.preventDefault(); // Mencegah form dari pengiriman default

                // Mendapatkan data form
                var formData = new FormData(this);
                console.log(this)

                // Mengirim data form ke server menggunakan AJAX
                $.ajax({
                    url: "/tanggapan/createOrUpdate", // URL rute untuk menangani form
                    type: 'POST', // Metode HTTP POST
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Menambahkan token CSRF ke dalam header
                    },
                    dataType: 'JSON',
                    data: formData, // Data form
                    processData: false, // Tidak memproses data (untuk FormData)
                    contentType: false, // Tidak menetapkan tipe konten (untuk FormData)
                    success: function(response) {
                        // Tampilkan alert di bawah tombol kirim tanggapan
                        $('#form-alert').html('<div class="alert alert-success">' + response.message + '</div>').show();

                        // Ubah status pengaduan di halaman detail
                        var statusElement = $('#status_pengaduan');
                        statusElement.removeClass();
                        if (response.status_pengaduan == '0') {
                            statusElement.addClass('status-belumproses fixed-width').text('Belum Proses');
                        } else if (response.status_pengaduan == 'proses') {
                            statusElement.addClass('status-proses fixed-width').text('Proses');
                        } else if (response.status_pengaduan == 'selesai') {
                            statusElement.addClass('status-selesai fixed-width').text('Selesai');
                        } else if (response.status_pengaduan == 'tolak') {
                            statusElement.addClass('status-tolak fixed-width').text('Tolak');
                        }
                        // Hilangkan alert setelah 3 detik
                        setTimeout(function() {
                            $('#form-alert').fadeOut();
                            //location.reload(); // Reload halaman
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        // Handle respons dari server jika terjadi kesalahan
                        console.log('Error saat menyimpan data:', error);
                        $('#form-alert').html('<div class="alert alert-danger">Terjadi kesalahan saat menyimpan data.</div>').show();

                    }
                });
            });

        });
    </script>


    @endsection
</body>

</html>