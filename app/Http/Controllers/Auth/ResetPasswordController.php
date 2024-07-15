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


class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        Log::info('Reset password request data:', $request->all());
    
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        Log::info('Validated data:', $validated);
    
        // Check if the user exists
        $user = \App\Models\Petugas::where('email', $request->email)->first();
        if (!$user) {
            Log::error('User not found:', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => [trans('passwords.user')],
            ]);
        }
    
        Log::info('User found:', ['user' => $user]);
    
        // Attempt to reset the user's password
        $status = Password::broker('petugass')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->kata_sandi_petugas = Hash::make($password);
                $user->save();
            }
        );
    
        Log::info('Password reset status:', ['status' => $status]);
    
        if ($status === Password::PASSWORD_RESET) {
            Log::info('Password reset successful for user:', ['email' => $request->email]);
            return response()->json(['message' => __($status)], 200);
        } else {
            Log::error('Password reset failed for user:', ['email' => $request->email, 'status' => $status]);
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }
}

