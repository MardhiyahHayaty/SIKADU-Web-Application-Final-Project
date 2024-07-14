<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        $masyarakat = Masyarakat::where('nik', $request->nik)->first();

        if (!$masyarakat || !Hash::check($request->password, $masyarakat->kata_sandi_masyarakat)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $masyarakat->createToken('mobile-app')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
