@extends('layouts.petugas')
@section('title','Data Profil Petugas')

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
    .flex-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .flex-container .form-group {
        flex: 1;
        min-width: 150px;
    }

    .control-label {
        margin-bottom: 4px;
        margin-top: 12px;
    }

    .btn-primary-profil {
        color: #fff;
        border: none;
        border-radius: 5px;
        background-color: #008080;
    }

    .btn-primary-profil:hover {
        color: #ffffff;
        background-color: #339999;
    }

    .btn-primary-password {
        color: #fff;
        border: none;
        border-radius: 5px;
        background-color: #008080;
    }

    .btn-primary-password:hover {
        color: #ffffff;
        background-color: #339999;
    }

    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }

    .profile-picture {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto;
        display: block;
        margin-top: 20px;
        margin-bottom: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
    }

    .control-label {
        margin-top: 12px;
    }

    .btn-primary-profile {
        color: #fff;
        width: 190px;
        border: none;
        border-radius: 5px;
        background-color: #008080;
    }

    .btn-primary-profile:hover {
        color: #ffffff;
        background-color: #339999;
    }
</style>
@endsection
@section('judul_header', 'Edit Profil')
</head>

<body>
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        <h4>Informasi Data Diri</h4>
                        <img src="{{url('storage/petugas/'.$petugasa->foto_petugas)}}" class="profile-picture">
                        <form id="formData_edit" enctype="multipart/form-data" method="post" style="margin-bottom: 0px;">
                            <input type="hidden" id="post_id">
                            <div class="form-group">
                                <label for="name" class="control-label">Nama Pengguna</label>
                                <input type="text" class="form-control" id="nama_petugas-edit" name="nama_petugas-edit" value="{{ $petugasa->nama_petugas }}" style="background-color: #EFF2F5;" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Nomor Induk Pegawai</label>
                                <input type="email" class="form-control" id="nip_petugas-edit" value="{{ $petugasa->nip_petugas }}" style="background-color: #EFF2F5;" readonly>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label">Alamat Email</label>
                                <input type="text" class="form-control" id="email_petugas-edit" value="{{ $petugasa->email }}" style="background-color: #EFF2F5;" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="telp_petugas-edit" value="{{ $petugasa->telp_petugas }}" style="background-color: #EFF2F5;" readonly>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Asal OPD</label>
                                <input type="text" class="form-control" id="id_opd-edit" value="{{ $petugasa->opd->nama_opd }}" style="background-color: #EFF2F5;" readonly>
                            </div>
                            <div class="button-container">
                                <a href="javascript:void(0)" id="btn-edit-profil" class="btn btn-primary-profil">Edit Data Profil</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        <h4>Ubah Kata Sandi</h4>
                        <form id="change-password-form" method="post" action="{{ route('petugas.updatePassword') }}">
                            @csrf
                            <div class="form-group">
                                <label for="current_password" class="control-label">Kata Sandi Saat Ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="control-label">Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="control-label">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="confirm_password" name="new_password_confirmation" required>
                            </div>
                            <div class="button-container">
                                <button type="submit" class="btn btn-primary-password">Ubah Kata Sandi</button>
                            </div>
                        </form>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#change-password-form').submit(function(e) {
                var newPassword = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();

                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Kata sandi baru dan konfirmasi kata sandi baru tidak cocok!'
                    });
                }
            });
        });
    </script>
    @include('petugas.profile.edit')
    @endsection
</body>

</html>
