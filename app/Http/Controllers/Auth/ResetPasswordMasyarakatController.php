<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\ResetsPasswords;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Password;

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class ResetPasswordMasyarakatController extends Controller
{

    public function reset(Request $request)
    {
        Log::info('Data permintaan reset kata sandi:', $request->all());

        try {
            $validated = $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
            ]);

            Log::info('Data tervalidasi:', $validated);

            // Memeriksa apakah pengguna ada
            $user = \App\Models\Masyarakat::where('email', $request->email)->first();
            if (!$user) {
                Log::error('Pengguna tidak ditemukan:', ['email' => $request->email]);
                throw ValidationException::withMessages([
                    'email' => [trans('passwords.user')],
                ]);
            }

            Log::info('Pengguna ditemukan:', ['user' => $user]);

            // Mencoba mereset kata sandi pengguna
            $status = Password::broker('masyarakats')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->kata_sandi_masyarakat = Hash::make($password);
                    $user->save();
                }
            );

            Log::info('Status reset kata sandi:', ['status' => $status]);

            if ($status === Password::PASSWORD_RESET) {
                Log::info('Reset kata sandi berhasil untuk pengguna:', ['email' => $request->email]);
                return response()->json(['message' => __($status)], 200);
            } else {
                Log::error('Reset kata sandi gagal untuk pengguna:', ['email' => $request->email, 'status' => $status]);
                throw ValidationException::withMessages([
                    'email' => [__($status)],
                ]);
            }
        } catch (ValidationException $e) {
            Log::error('Validasi gagal:', ['errors' => $e->errors()]);
            throw $e;
        }
    }
}

