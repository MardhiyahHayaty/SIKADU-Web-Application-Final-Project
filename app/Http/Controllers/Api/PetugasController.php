<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PetugasResource;
use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan Eloquent untuk melakukan join
        $petugasa = Petugas::with('opd')->paginate(100);
        return new PetugasResource(true, 'List Data Petugas', $petugasa);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip_petugas'=> 'required',
            'nama_petugas' => 'required',
            'email_petugas'=> 'required',
            'telp_petugas' => 'required|regex:/[0-9]{9,14}/', // Aturan validasi untuk nomor telepon
            'id_opd'=> 'required',
            'kata_sandi_petugas' => 'required',
            'foto_petugas'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'level' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto_petugas = $request->file('foto_petugas');
        $foto_petugas -> storeAs('public/petugas', $foto_petugas->hashName());

        $petugasa = Petugas::create([
            'nip_petugas' => $request->nip_petugas,
            'nama_petugas' => $request->nama_petugas,
            'email_petugas' => $request->email_petugas,
            'telp_petugas' => $request->telp_petugas,
            'id_opd' => $request->id_opd,
            'kata_sandi_petugas' => password_hash($request->kata_sandi_petugas, PASSWORD_DEFAULT),
            'foto_petugas' => $foto_petugas->hashName(),
            'level' => $request->level,
        ]);

        return new PetugasResource(true, 'Data Petugas Berhasil Ditambahkan!', $petugasa);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Petugas $petugasa)
    {
        return new PetugasResource(true, 'Data Petugas Ditemukan!', $petugasa);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petugas $petugasa)
    {
        $validator = Validator::make($request->all(), [
            'nip_petugas'=> 'required',
            'nama_petugas' => 'required',
            'email_petugas'=> 'required',
            'telp_petugas' => 'required',
            'id_opd'=> 'required',
            //'kata_sandi_petugas' => 'required',
            'foto_petugas'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'level'=> 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $petugasa = $petugasa->fresh(); // Ambil data petugas yang terbaru

        if ($request->hasFile('foto_petugas')){
            $foto_petugas = $request->file('foto_petugas');
            $foto_petugas->storeAs('public/petugas', $foto_petugas->hashName());

            if ($petugasa->foto_petugas) {
                Storage::delete('public/petugas/'.$petugasa->foto_petugas);
            }

            $petugasa->foto_petugas = $foto_petugas->hashName();
        }

        $petugasa->nip_petugas = $request->nip_petugas;
        $petugasa->nama_petugas = $request->nama_petugas;
        $petugasa->email_petugas = $request->email_petugas;
        $petugasa->telp_petugas = $request->telp_petugas;
        $petugasa->id_opd = $request->id_opd;
        $petugasa->kata_sandi_petugas = password_hash($request->kata_sandi_petugas, PASSWORD_DEFAULT);
        $petugasa->level = $request->level;
        $petugasa->save();

        return new PetugasResource(true, 'Data Petugas Berhasil Diubah!', $petugasa);
    }

    /*public function update(Request $request, Petugas $petugas)
    {
        $validator = Validator::make($request->all(), [
            'nip_petugas'=> 'required',
            'nama_petugas' => 'required',
            'email_petugas'=> 'required',
            'telp_petugas' => 'required',
            'id_opd'=> 'required',
            'kata_sandi_petugas' => 'required',
            'foto_petugas'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $petugas = $petugas->fresh(); //Ambil data petugas yang terbaru

        if ($request->hasFile('foto_petugas')){
            $foto_petugas = $request->file('foto_petugas');
            $foto_petugas -> storeAs('public/petugas', $foto_petugas->hashName());

            Storage::delete('public/petugas/'.$petugas->foto_petugas);

            $petugas->update([
                'nip_petugas' => $request->nip_petugas,
                'nama_petugas' => $request->nama_petugas,
                'email_petugas' => $request->email_petugas,
                'telp_petugas' => $request->telp_petugas,
                'id_opd' => $request->id_opd,
                'kata_sandi_petugas' => $request->kata_sandi_petugas,
                'foto_petugas' => $foto_petugas->hashName(),
            ]);
        } else {
            $petugas->update([
                'nip_petugas' => $request->nip_petugas,
                'nama_petugas' => $request->nama_petugas,
                'email_petugas' => $request->email_petugas,
                'telp_petugas' => $request->telp_petugas,
                'id_opd' => $request->id_opd,
                'kata_sandi_petugas' => $request->kata_sandi_petugas,
                //'foto_petugas' => $foto_petugas->hashName(),
            ]);
            return new PetugasResource(true, 'Data Petugas Berhasil Diubah!', $petugas);
        }
    }*/

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petugas $petugasa)
    {
        $petugasa->delete();
        return new PetugasResource(true, 'Data Petugas Berhasil Dihapus!', null);
    }
}
