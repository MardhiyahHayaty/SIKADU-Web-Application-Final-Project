<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AspirasiResource;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AspirasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aspirasi = Aspirasi::with('masyarakat', 'jenis')->paginate(100);
        return new AspirasiResource(true, 'List Data Aspirasi', $aspirasi);
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
            'nik'=> 'required',
            //'tgl_aspirasi' => 'required',
            'id_jenis_aduan' => 'required',
            'judul_aspirasi' => 'required',
            'isi_aspirasi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        date_default_timezone_set('Asia/Jakarta');

        $aspirasi = Aspirasi::create([
            'nik' => $request->nik,
            'tgl_aspirasi' => date('Y-m-d H:i:s'),
            'id_jenis_aduan' => $request->id_jenis_aduan,
            'judul_aspirasi' => $request->judul_aspirasi,
            'isi_aspirasi' => $request->isi_aspirasi,
        ]);

        return new AspirasiResource(true, 'Data Aspirasi Berhasil Ditambahkan!', $aspirasi);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspirasi $aspirasi)
    {
        return new AspirasiResource(true, 'Data Aspirasi Ditemukan!', $aspirasi);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
