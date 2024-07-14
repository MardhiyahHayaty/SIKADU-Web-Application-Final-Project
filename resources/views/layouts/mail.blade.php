<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <style>
            p {
                font-size: 12px;
                margin-bottom: 0;
            }

            .fw-bold {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div>
            <p>Pengaduan Anda Telah di Tanggapi!</p>
            <br>
            <p>Halo, ({{$masyarakat->nama_masyarakat}})</p>
            <br>
            <p>Tanggapan untuk pengaduan Anda dengan nomor pengaduan ({{$tanggapan->id_pengaduan}}) telah diperbarui.</p>
            <br>
            <p class="fw-bold">Status Pengaduan:</p>
            <p>{{  $tanggapan->status_tanggapan }}</p>
            <br>
            <p class="fw-bold">Isi Tanggapan:</p>
            <p>{{ $tanggapan->isi_tanggapan }}</p>
            <br>
            <p>Terima kasih atas partisipasi Anda.</p>
            <br>
            <p>Salam,</p>
        </div>
    </body>
</html>
