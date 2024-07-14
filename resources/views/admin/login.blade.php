<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css">
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css">

    <style>
        body {
            background-color: #008080;
        }

        .btn-purple {
            background-color: #008080;
            width: 100%;
            color: #ffffff;
        }
    </style>

    <title>Halaman Masuk Petugas</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img alt="Logo" src="assets/media/logos/foto-login.png" style="margin-top: 18%; margin-left: 12%; height: 500px;">
            </div>
            <div class="col-md-6">
                <div class="card" style="border-radius: 50px; padding: 40px; margin-top: 20%; margin-bottom: 20%; box-shadow: 0 0 16px rgba(0, 0, 0, 0.5);">
                    <div class="card-body">
                        <div class="logo-container" style="display: flex; justify-content: center;">
                            <img alt="Logo" src="assets/media/logos/sikadu-logo.png" style="width: 200px; margin-bottom: 18px;">
                        </div>
                        <h6 class="text-center text-black" style="margin-bottom: 40px;">Sistem Informasi Pengaduan Masyarakat Pekanbaru</h6>
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="control-label">Alamat Email</label>
                                <input type="email" name="email_petugas" placeholder="Alamat Email Petugas" class="form-control mb-5">
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Kata Sandi</label>
                                <input type="password" name="kata_sandi_petugas" placeholder="Kata Sandi Petugas" class="form-control mb-5">
                            </div>
                            <button type="submit" class="btn btn-purple">MASUK</button>
                           
                        </form>
                    </div>
                    @if (Session::has('pesan'))
                    <div class="alert alert-danger mt-2">
                        {{ Session::get('pesan') }}
                    </div>
                    @endif

                    <!-- Link lupa kata sandi 
                    <p class="text-center mt-3">
                            <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                        </p>
                    -->
                </div>
            </div>
        </div>
    </div>

</body>

</html>