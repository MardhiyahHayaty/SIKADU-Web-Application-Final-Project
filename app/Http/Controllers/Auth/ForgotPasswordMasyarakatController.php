<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordMasyarakatController extends Controller
{
    // use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        Log::info('Reset password request received:', $request->all());

        $request->validate(['email' => 'required|email']);

        $masyarakat = Masyarakat::where('email', $request->email)->first();
        //dd($masyarakat);

        Log::info('Masyarakat found:', ['masyarakat' => $masyarakat]);

        if (!$masyarakat) {
            Log::warning('Masyarakat not found:', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => ['Email masyarakat tidak ditemukan.'],
            ]);
        }

        // Generate token and send reset link email
        $status = Password::broker('masyarakats')->sendResetLink(
            ['email' => $request->email]
        );

        Log::info('Password reset link status:', ['status' => $status]);

        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Password reset link sent:', ['email' => $request->email]);
            return response()->json(['message' => __($status)], 200);
        }

        Log::error('Failed to send password reset link:', ['status' => $status]);
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }

    // Atur broker untuk proses reset password
    public function broker()
    {
        return Password::broker();
    }
}
