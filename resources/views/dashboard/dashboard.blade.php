@extends('layouts.petugas')
@section('title','Dashboard')

@php
use Illuminate\Support\Str;
@endphp
@section('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>


<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        /* Total width of 4 cards (232px each) */
        margin: 0 auto;
    }

    .flex-container {
        display: flex;
        align-items: center;
        /* Mengatur vertikal align */
    }

    .text-left {
        flex: 1;
        /* Agar element ini menempati sisa ruang */
    }

    p {
        margin-bottom: 0px;
    }

    .card-body {
        width: 200px;
        /* Width of each card */
        margin: 10px;
        background-color: #ffffff;
        border-radius: 8px;
        padding-left: 28px;
        padding-right: 28px;
        padding-top: 14px;
        padding-bottom: 14px;
        box-shadow: 0 4px 6px rgba(0, 128, 128, 0.1);
    }

    .status-proses,
    .status-selesai,
    .status-belumproses {
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

    .fixed-width {
        width: 80px;
        /* Tentukan lebar yang sesuai */
        display: inline-block;
        text-align: center;
    }

    .card-body-tabel {
        padding-right: 2.25rem;
        padding-left: 2.25rem;
        padding-bottom: 2rem;
        padding-top: 0px;
    }

    .btn-lihat-semua {
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        background-color: #008080;
    }

    .btn-lihat-semua:hover {
        color: #ffffff;
        background-color: #339999;
    }

    #pengaduanChart,#jenisAduanChart {
        padding: 2%;
    }

    #map {
        height: 400px;
        width: 96%;
        margin-left: 2%;
        margin-top: 16px;
        margin-right: 2%;
        margin-bottom: 2%;
        border-radius: 6px;
    }

    .kpi-indicator {
        text-align: center;
        /*margin: 10px 0;*/
        margin-bottom: 16px;
    }
    .kpi-indicator p.status {
        font-size: 24px;
        font-weight: bold;
    }
    .kpi-indicator .good {
        color: #0ba327;
    }
    .kpi-indicator .average {
        color: orange;
    }
    .kpi-indicator .bad {
        color: red;
    }
    .kpi-indicator .label {
        display: block;
        font-size: 16px;
        margin-top: 5px;
    }

    .container {
        width: 100%;
    }

    .chart-header {
        text-align: left;
        font-size: 14px;
        font-weight: 600;
        margin-top: 20px;
        margin-left: 20px;
        color: #181c32;
        font-family: Poppins;
    }
    
    .chart-header2 {
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        margin-top: 20px;
        margin-left: 20px;
        margin-bottom: 10px;
        color: #181c32;
        font-family: Poppins;
    }
</style>

@endsection
@section('judul_header', 'Dashboard')
</head>

<body>
    @section('content')
    <div class="row">
        <div class="container">
            <div class="card-container">
                <div class="card-body" id="clickable-belumproses">
                    <div class="flex-container">
                        <div class="text-left">
                            <p style="font-size: 24px; font-weight: bold;">{{ $pengaduans_0 }}</p>
                            <p>Pengaduan</p>
                            <p style="color: #C62828;"></p>
                        </div>
                        <img alt="Logo" src="assets/media/icons/pengaduan-0-ikon.png" class="h-52px">
                    </div>
                </div>
                <div class="card-body" id="clickable-proses">
                    <div class="flex-container">
                        <div class="text-left">
                            <p style="font-size: 24px; font-weight: bold;">{{ $pengaduans_proses }}</p>
                            <p>Pengaduan</p>
                            <p style="color: #329999;">Sedang Proses</p>
                        </div>
                        <img alt="Logo" src="assets/media/icons/pengaduan-proses-ikon.png" class="h-52px">
                    </div>
                </div>
                <div class="card-body" id="clickable-selesai">
                    <div class="flex-container">
                        <div class="text-left">
                            <p style="font-size: 24px; font-weight: bold;">{{ $pengaduans_selesai }}</p>
                            <p>Pengaduan</p>
                            <p style="color: #2C73EB;">Selesai</p>
                        </div>
                        <img alt="Logo" src="assets/media/icons/pengaduan-selesai-ikon.png" class="h-52px">
                    </div>
                </div>
                <div class="card-body" id="clickable-masyarakat">
                    <div class="flex-container">
                        <div class="text-left">
                            <p style="font-size: 24px; font-weight: bold;">{{ $masyarakat }}</p>
                            <p>Masyarakat</p>
                        </div>
                        <img alt="Logo" src="assets/media/icons/masyarakat-ikon.png" class="h-52px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container">
            <div class="card-container">
                <div class="card-body">
                    <p class="chart-header">Total Pengaduan Per Bulan</p>
                    <canvas id="pengaduanChart"></canvas>
                </div>
                <div class="card-body">
                    <p class="chart-header">Total Pengaduan Berdasarkan Jenis Pengaduan</p>
                    <canvas id="jenisAduanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container" style="margin: 10px; width: 98.4%; display: flex;">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                <p class="chart-header">Persebaran Lokasi Pengaduan</p>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container" style="margin: 10px; width: 98.4%; display: flex;">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="kpi-indicator">
                        <p class="chart-header2">Waktu Rata-Rata Penyelesaian Pengaduan</p>
                        <p class="status {{ $waktuRataRataPenyelesaian <= 3 ? 'good' : ($waktuRataRataPenyelesaian <= 5 ? 'average' : 'bad') }}">
                            {{ $waktuRataRataPenyelesaian }} hari 
                            <span class="label">
                                {{ $waktuRataRataPenyelesaian <= 3 ? 'Sangat Baik' : ($waktuRataRataPenyelesaian <= 5 ? 'Standar' : 'Buruk') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

            

    <style>
        .text-end {
            text-align: right;
        }
    </style>

<script>
        
        var ctx = document.getElementById('pengaduanChart').getContext('2d');
        var pengaduanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($pengaduanPerBulan->pluck('bulan')),
                datasets: [{
                    label: 'Total Pengaduan',
                    data: @json($pengaduanPerBulan->pluck('total_pengaduan')),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxJenisAduan = document.getElementById('jenisAduanChart').getContext('2d');
        var jenisAduanChart = new Chart(ctxJenisAduan, {
            type: 'bar',
            data: {
                labels: @json($pengaduanPerJenis->pluck('nama_jenis_aduan')),
                datasets: [{
                    label: 'Total Pengaduan',
                    data: @json($pengaduanPerJenis->pluck('total_pengaduan')),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

    <script>
        document.getElementById('clickable-belumproses').addEventListener('click', function() {
            window.location.href = "{{ route('pengaduan.filter', ['status_pengaduan' => '0']) }}";
        });

        document.getElementById('clickable-proses').addEventListener('click', function() {
            window.location.href = "{{ route('pengaduan.filter', ['status_pengaduan' => 'proses']) }}";
        });

        document.getElementById('clickable-selesai').addEventListener('click', function() {
            window.location.href = "{{ route('pengaduan.filter', ['status_pengaduan' => 'selesai']) }}";
        });

        document.getElementById('clickable-masyarakat').addEventListener('click', function() {
            window.location.href = "http://127.0.0.1:8000/masyarakat";
        });
    </script>


<script>
    var map = L.map('map');

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);

    var peta_pengaduans = @json($peta_pengaduans);
    console.log(peta_pengaduans); // Menambahkan log untuk debug

    // Buat grup cluster
    var markers = L.markerClusterGroup();
    var bounds = new L.LatLngBounds();

    peta_pengaduans.forEach(function(pengaduan) {
        var marker = L.marker([pengaduan.latitude, pengaduan.longitude])
            .bindPopup(pengaduan.locationName);
        markers.addLayer(marker);
        bounds.extend(marker.getLatLng());
    });

    map.addLayer(markers);
    map.fitBounds(bounds);
</script>

@endsection
</body>

</html>