<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Tampilkan form untuk meminta email reset password
    public function showLinkRequestForm()
    {
        return view('admin.email');
    }

    // Proses pengiriman email reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mengirim email reset password
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        // Memberikan respons berdasarkan status pengiriman email
        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

    // Atur broker untuk proses reset password
    public function broker()
    {
        return Password::broker();
    }
}
