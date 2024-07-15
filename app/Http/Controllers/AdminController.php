<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //Untuk mengarahkan ke halaman login
    public function formLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $email_petugas = Petugas::where('email', $request->email_petugas)->first();

        if (!$email_petugas) {
            return redirect()->back()->with(['pesan' => 'Alamat email atau kata sandi tidak sesuai!']);
        }

        $kata_sandi_petugas = Hash::check($request->kata_sandi_petugas, $email_petugas->kata_sandi_petugas);

        if (!$kata_sandi_petugas) {
            return redirect()->back()->with(['pesan' => 'Alamat email atau kata sandi tidak sesuai!']);
        }

        $auth = Auth::guard('admin')->attempt(['email' => $request->email_petugas, 'password' => $request->kata_sandi_petugas]);

        if ($auth) {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.formLogin');
    }
}
