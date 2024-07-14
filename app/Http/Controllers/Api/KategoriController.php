<?php

namespace App\Http\Controllers\Api;

use App\Models\Kategori;
use App\Http\Resources\KategoriResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::latest()->paginate(100);
        return new KategoriResource(true, 'List Data Kategori', $kategori);
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
            'nama_kategori' => 'required',
            'foto_kategori' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto_kategori = $request->file('foto_kategori');
        $foto_kategori->storeAs('public/kategori', $foto_kategori->hashName());

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'foto_kategori' => $foto_kategori->hashName(),
        ]);

        return new KategoriResource(true, 'Data Kategori Berhasil Ditambahkan!', $kategori);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return new KategoriResource(true, 'Data Kategori Ditemukan!', $kategori);
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
    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'foto_kategori' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('foto_kategori')){

            $foto_kategori = $request->file('foto_kategori');
            $foto_kategori -> storeAs('public/kategori', $foto_kategori->hashName());

            Storage::delete('public/kategori/'.$kategori->foto_kategori);

            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'foto_kategori' => $foto_kategori->hashName(),
            ]);
        } else {

            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                //'foto_kategori' => $foto_kategori->hashName(),
            ]);
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return new KategoriResource(true, 'Data Kategori Berhasil Diubah!', $kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return new KategoriResource(true, 'Data Kategori Berhasil Dihapus!', null);
    }
}
