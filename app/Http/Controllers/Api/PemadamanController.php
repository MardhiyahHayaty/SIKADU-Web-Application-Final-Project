<?php

namespace App\Http\Controllers\Api;

use App\Models\Pemadaman;
use App\Http\Resources\PemadamanResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemadamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemadaman = Pemadaman::with('petugas')->paginate(100);
        return new PemadamanResource(true, 'List Data Pemadaman Listrik', $pemadaman);
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
            'judul_pemadaman'=> 'required',
            'tgl_mulai_pemadaman' => 'required',
            'jam_mulai_pemadaman' => 'required',
            'jam_selesai_pemadaman' => 'required',
            'lokasi_pemadaman' => 'required',
            //'status_pemadaman' => 'required',
            'id_petugas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pemadaman = Pemadaman::create([
            'judul_pemadaman' => $request->judul_pemadaman,
            'tgl_mulai_pemadaman' => $request->tgl_mulai_pemadaman,
            'jam_mulai_pemadaman' => $request->jam_mulai_pemadaman,
            'jam_selesai_pemadaman' => $request->jam_selesai_pemadaman,
            'lokasi_pemadaman' => $request->lokasi_pemadaman,
            'status_pemadaman' => "Mendatang",
            'id_petugas' => $request->id_petugas,
        ]);

        return new PemadamanResource(true, 'Data Pemadaman Listrik Berhasil Ditambahkan!', $pemadaman);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemadaman $pemadaman)
    {
        return new PemadamanResource(true, 'Data Pemadaman Listrik Ditemukan!', $pemadaman);
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
    public function update(Request $request, Pemadaman $pemadaman)
    {
        $validator = Validator::make($request->all(), [
            'judul_pemadaman'=> 'required',
            'tgl_mulai_pemadaman' => 'required',
            'jam_mulai_pemadaman' => 'required',
            'jam_selesai_pemadaman' => 'required',
            'lokasi_pemadaman' => 'required',
            //'status_pemadaman' => 'required',
            'id_petugas' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $pemadaman->update([
            'judul_pemadaman' => $request->judul_pemadaman,
            'tgl_mulai_pemadaman' => $request->tgl_mulai_pemadaman,
            'jam_mulai_pemadaman' => $request->jam_mulai_pemadaman,
            'jam_selesai_pemadaman' => $request->jam_selesai_pemadaman,
            'lokasi_pemadaman' => $request->lokasi_pemadaman,
            'status_pemadaman' => $request->status_pemadaman,
            'id_petugas' => $request->id_petugas,
        ]);

        return new PemadamanResource(true, 'Data Pemadaman Listrik Berhasil Diubah!', $pemadaman);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemadaman $pemadaman)
    {
        $pemadaman->delete();
        return new PemadamanResource(true, 'Data Pemadaman Listrik Berhasil Dihapus!', null);
    }
}
