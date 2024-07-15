<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Tampilkan form untuk reset password dengan token
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Atur broker untuk proses reset password
    public function broker()
    {
        return Password::broker();
    }
}
