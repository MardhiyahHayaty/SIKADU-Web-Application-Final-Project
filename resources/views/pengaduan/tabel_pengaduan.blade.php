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
            <td>{{ $pengaduan-> masyarakat -> email }}</td>
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