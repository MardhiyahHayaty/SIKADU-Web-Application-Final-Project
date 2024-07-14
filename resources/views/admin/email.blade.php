<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css">
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css">

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

    <title>Lupa Kata Sandi</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img alt="Logo" src="{{ asset('assets/media/logos/foto-login.png') }}" style="margin-top: 18%; margin-left: 12%; height: 500px;">
            </div>
            <div class="col-md-6">
                <div class="card" style="border-radius: 50px; padding: 40px; margin-top: 20%; margin-bottom: 20%; box-shadow: 0 0 16px rgba(0, 0, 0, 0.5);">
                    <div class="card-body">
                        <div class="logo-container" style="display: flex; justify-content: center;">
                            <img alt="Logo" src="{{ asset('assets/media/logos/sikadu-logo.png') }}" style="width: 200px; margin-bottom: 18px;">
                        </div>
                        <h6 class="text-center text-black" style="margin-bottom: 40px;">Sistem Informasi Pengaduan Masyarakat Pekanbaru</h6>
                        <!-- resources/views/auth/passwords/email.blade.php -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <input type="email" name="email" value="{{ old('email') }}" required>
                            <button type="submit">Kirim Tautan Reset Kata Sandi</button>
                        </form>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success mt-2">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>

</html>
