<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700')}}">
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css">
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css">

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
                <img alt="Logo" src="{{asset('assets/media/logos/foto-login.png')}}" style="margin-top: 18%; margin-left: 12%; height: 500px;">
            </div>
            <div class="col-md-6">
                <div class="card" style="border-radius: 50px; padding: 40px; margin-top: 20%; margin-bottom: 20%; box-shadow: 0 0 16px rgba(0, 0, 0, 0.5);">
                    <div class="card-body">
                        <h6 class="text-center text-black" style="margin-bottom: 40px;">Lupa Kata Sandi</h6>
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="control-label">Alamat Email</label>
                                <input type="email" name="email_petugas" placeholder="Alamat Email Petugas" class="form-control mb-5">
                            </div>
                            <button type="submit" class="btn btn-purple">Kirim Tautan Reset Kata Sandi</button>
                            
                        </form>
                    </div>
                    @if (Session::has('pesan'))
                    <div class="alert alert-danger mt-2">
                        {{ Session::get('pesan') }}
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

</body>

</html>