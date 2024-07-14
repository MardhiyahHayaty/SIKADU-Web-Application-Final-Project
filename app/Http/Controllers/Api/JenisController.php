<?php

namespace App\Http\Controllers\Api;

use App\Models\Jenis;
use App\Http\Resources\JenisResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan Eloquent untuk melakukan join
        $jenisa = Jenis::with('kategori', 'opd')->paginate(100);
        return new JenisResource(true, 'List Jenis Aduan', $jenisa);
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
            'id_kategori'=> 'required',
            'nama_jenis_aduan' => 'required',
            'id_opd'=> 'required',
            'foto_jenis_aduan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto_jenis_aduan = $request->file('foto_jenis_aduan');
        $foto_jenis_aduan->storeAs('public/jenis', $foto_jenis_aduan->hashName());

        $jenisa = Jenis::create([
            'id_kategori' => $request->id_kategori,
            'nama_jenis_aduan' => $request->nama_jenis_aduan,
            'id_opd' => $request->id_opd,
            'foto_jenis_aduan' => $foto_jenis_aduan->hashName(),
            
        ]);

        return new JenisResource(true, 'Data Jenis Aduan Berhasil Ditambahkan!', $jenisa);
    
    }


    /**
     * Display the specified resource.
     */
    public function show(Jenis $jenisa)
    {
        return new JenisResource(true, 'Data Jenis Aduan Ditemukan!', $jenisa);
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
    public function update(Request $request, Jenis $jenisa)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'nama_jenis_aduan' => 'required',
            'id_opd' => 'required',
            'foto_jenis_aduan' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('foto_jenis_aduan')){

            $foto_jenis_aduan = $request->file('foto_jenis_aduan');
            $foto_jenis_aduan -> storeAs('public/jenis', $foto_jenis_aduan->hashName());

            Storage::delete('public/jenis/'.$jenisa->foto_jenis_aduan);

            $jenisa->update([
                'id_kategori' => $request->id_kategori,
                'nama_jenis_aduan' => $request->nama_jenis_aduan,
                'id_opd' => $request->id_opd,
                'foto_jenis_aduan' => $foto_jenis_aduan->hashName(),
            ]);
        } else {

            $jenisa->update([
                'id_kategori' => $request->id_kategori,
                'nama_jenis_aduan' => $request->nama_jenis_aduan,
                'id_opd' => $request->id_opd,
                //'foto_jenis_aduan' => $foto_jenis_aduan->hashName(),
            ]);
        }

        return new JenisResource(true, 'Data Jenis Aduan Berhasil Diubah!', $jenisa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis $jenisa)
    {
        $jenisa->delete();
        return new JenisResource(true, 'Data Jenis Aduan Berhasil Dihapus!', null);
    }
}
