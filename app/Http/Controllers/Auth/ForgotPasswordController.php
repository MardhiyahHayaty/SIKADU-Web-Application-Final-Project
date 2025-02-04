<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    // use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Tampilkan form untuk meminta email reset password
    public function showLinkRequestForm()
    {
        return view('admin.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $petugas = Petugas::where('email', $request->email)->first();
        // dd($petugas);

        if (!$petugas) {
            throw ValidationException::withMessages([
                'email' => ['Email petugas tidak ditemukan.'],
            ]);
        }

        // Generate token and send reset link email
        $status = Password::broker('petugass')->sendResetLink(
            ['email' => $request->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 200);
        }

        throw ValidationException::withMessages([
            'email_petugas' => [__($status)],
        ]);
    }

    // Atur broker untuk proses reset password
    public function broker()
    {
        return Password::broker();
    }
}
