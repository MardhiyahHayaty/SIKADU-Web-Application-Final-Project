<?php

namespace App\Http\Controllers\Api;

use App\Models\Berita;
use App\Http\Resources\BeritaResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::with('petugas')->paginate(100);
        return new BeritaResource(true, 'List Data Berita', $berita);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_berita'=> 'required',
            'isi_berita' => 'required',
            'foto_berita' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //'tgl_terbit_berita' => 'required',
            'id_petugas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto_berita = $request->file('foto_berita');
        $foto_berita->storeAs('public/berita', $foto_berita->hashName());

        $berita = Berita::create([
            'judul_berita' => $request->judul_berita,
            'isi_berita' => $request->isi_berita,
            'foto_berita' => $foto_berita->hashName(),
            'tgl_terbit_berita' => date('Y-m-d H:i:s'),
            'id_petugas' => $request->id_petugas,
        ]);

        return new BeritaResource(true, 'Data Berita Berhasil Ditambahkan!', $berita);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return new BeritaResource(true, 'Data Berita Ditemukan!', $berita);
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
    public function update(Request $request, Berita $berita)
    {
        $validator = Validator::make($request->all(), [
            //'nik' => 'required',
            'judul_berita'=> 'required',
            'isi_berita' => 'required',
            'foto_berita' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tgl_terbit_berita' => 'required',
            'id_petugas' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('foto_berita')){

            $foto_berita = $request->file('foto_berita');
            $foto_berita -> storeAs('public/berita', $foto_berita->hashName());

            Storage::delete('public/berita/'.$berita->foto_berita);

            $berita->update([
                'judul_berita' => $request->judul_berita,
                'isi_berita' => $request->isi_berita,
                'foto_berita' => $foto_berita->hashName(),
                'tgl_terbit_berita' => $request->tgl_terbit_berita,
                'id_petugas' => $request->id_petugas,
            ]);
        } else {

            $berita->update([
                'judul_berita' => $request->judul_berita,
                'isi_berita' => $request->isi_berita,
                //'foto_berita' => $foto_berita->hashName(),
                'tgl_terbit_berita' => $request->tgl_terbit_berita,
                'id_petugas' => $request->id_petugas,
            ]);
        }

        return new BeritaResource(true, 'Data Berita Berhasil Diubah!', $berita);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        $berita->delete();
        return new BeritaResource(true, 'Data Berita Berhasil Dihapus!', null);
    }
}
