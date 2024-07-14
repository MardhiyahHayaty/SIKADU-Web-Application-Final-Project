<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    use Notifiable;

    public function index()
    {
        $petugasa = Petugas::join('opds', 'opds.id', '=', 'petugasa.id_opd')
            ->select('petugasa.*', 'opds.nama_opd')
            ->latest()->paginate(10);

        $opds = Opd::all();

        return view('petugas.list_petugas', compact('opds', 'petugasa'));
    }

    public function showProfile()
    {
        $petugasa = Auth::guard('admin')->user();  // Menggunakan default guard
        $opds = Opd::all();

        return view('petugas.profile.show', compact('petugasa', 'opds'));
    }

    public function update(Request $request, $id)
    {
        $petugasa = Petugas::findOrFail($id);

        $request->validate([
            'nama_petugas' => 'required',
            'nip_petugas' => 'required',
            'email_petugas' => 'required',
            'telp_petugas' => 'required',
            'id_opd' => 'required',
            'foto_petugas' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto_petugas')) {
            $file = $request->file('foto_petugas');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/petugas', $filename);

            // Delete old file if it exists
            if ($petugasa->foto_petugas) {
                Storage::delete('public/petugas/' . $petugasa->foto_petugas);
            }

            $petugasa->foto_petugas = $filename;
        }

        $petugasa->nama_petugas = $request->nama_petugas;
        $petugasa->nip_petugas = $request->nip_petugas;
        $petugasa->email_petugas = $request->email_petugas;
        $petugasa->telp_petugas = $request->telp_petugas;
        $petugasa->id_opd = $request->id_opd;
        $petugasa->save();

        return response()->json(['message' => 'Profil berhasil diperbarui']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $petugas = Auth::guard('admin')->user();

        if (!$petugas || !Hash::check($request->current_password, $petugas->kata_sandi_petugas)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak benar']);
        }

        $petugas->kata_sandi_petugas = Hash::make($request->new_password);
        $petugas->save();

        return back()->with('status', 'Kata sandi berhasil diubah!');
    }
}
