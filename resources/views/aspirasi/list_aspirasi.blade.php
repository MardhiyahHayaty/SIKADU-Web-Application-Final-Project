@extends('layouts.petugas')
@section('title','List Data Aspirasi')

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

    #detailIsiAspirasi {
        width: 100%;
        min-height: 100px;
        resize: vertical; /* Biarkan textarea dapat di-resize secara vertikal */
    }
</style>
@endsection
@section('judul_header', 'Data Aspirasi')
</head>

<body>
    @section('content')
    <div class="row">
        <!--begin::Search bar-->
        <div class="col-md-10">
            <div class="form-group">
                <input type="search" class="form-control" id="search" name="search" placeholder="Cari Data Aspirasi" style="width: 50%; margin-left: 30px" />
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
                                    <th>Jenis Aspirasi</th>
                                    <th>Nama OPD</th>
                                    <th style="width: 18%;">Judul Aspirasi</th>
                                    <th style="width: 25%;">Isi Aspirasi</th>
                                    <th style="width: 13%;">Tanggal</th>
                                    <th style="width: 1%;"></th>
                                </tr>
                            </thead>
                            <tbody id="table-aspirasi" style="font-size: 12px;">
                                @php
                                // Hitung nomor urut berdasarkan halaman saat ini dan iterasi
                                $currentPage = $aspirasis->currentPage();
                                $itemsPerPage = $aspirasis->perPage();
                                $startingNumber = ($currentPage - 1) * $itemsPerPage + 1;
                                @endphp
                                @foreach($aspirasis as $aspirasi)
                                <tr id="index_{{ $aspirasi->id }}">
                                    <td>
                                    <td>{{ $loop->iteration + $startingNumber - 1 }}</td>
                                    <td>{{ $aspirasi-> nik }}</td>
                                    <td>{{ $aspirasi-> jenis -> nama_jenis_aduan }}</td>
                                    <td>{{ $aspirasi-> jenis -> opd -> nama_opd }}</td>
                                    <td>{{ $aspirasi-> judul_aspirasi }}</td>
                                    <td>{{ Str::limit($aspirasi-> isi_aspirasi, 150) }}</td>
                                    <td>{{ $aspirasi-> tgl_aspirasi }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <p>Showing {{ $aspirasis->firstItem() }} to {{ $aspirasis->lastItem() }} of {{ $aspirasis->total() }} data</p>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-end">
                                    {!! $aspirasis->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Aspirasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formDetail" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label for="nik" class="control-label">NIK</label>
                            <input type="text" class="form-control" id="detailNik" style="background-color: #EFF2F5;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jenisAspirasi" class="control-label">Jenis Aspirasi</label>
                            <input type="text" class="form-control" id="detailJenisAspirasi" style="background-color: #EFF2F5;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="namaOpd" class="control-label">Nama OPD</label>
                            <input type="text" class="form-control" id="detailNamaOpd" style="background-color: #EFF2F5;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="judulAspirasi" class="control-label">Judul Aspirasi</label>
                            <input type="text" class="form-control" id="detailJudulAspirasi" style="background-color: #EFF2F5;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="isiAspirasi" class="control-label">Isi Aspirasi</label>
                            <textarea class="form-control" id="detailIsiAspirasi" rows="6" style="background-color: #EFF2F5;" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tglAspirasi" class="control-label">Tanggal</label>
                            <input type="text" class="form-control" id="detailTanggal" style="background-color: #EFF2F5;" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#table-aspirasi').on('click', 'tr', function() {
            var aspirasiId = $(this).attr('id').split('_')[1];

            $.ajax({
                url: '/aspirasi/' + aspirasiId,
                method: 'GET',
                success: function(data) {
                    $('#detailNik').val(data.nik);
                    $('#detailJenisAspirasi').val(data.jenis.nama_jenis_aduan);
                    $('#detailNamaOpd').val(data.jenis.opd.nama_opd);
                    $('#detailJudulAspirasi').val(data.judul_aspirasi);
                    $('#detailIsiAspirasi').val(data.isi_aspirasi);
                    $('#detailTanggal').val(data.tgl_aspirasi);

                    // Tampilkan modal
                    $('#detailModal').modal('show');
                },
                error: function() {
                    alert('Gagal mengambil detail aspirasi');
                }
            });
        });
    });
</script>


    @endsection
</body>

</html>