<?php

namespace App\Http\Controllers\Api;

use App\Models\Masyarakat;
use App\Http\Resources\MasyarakatResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masyarakats = Masyarakat::latest()->paginate(100);
        return new MasyarakatResource(true, 'List Data Masyarakat', $masyarakats);
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
            'nik' => 'required',
            'nama_masyarakat' => 'required',
            'email' => 'required',
            'telp_masyarakat' => 'required',
            'kata_sandi_masyarakat' => 'required',
            'foto_masyarakat' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            //'tgl_lahir_masyarakat' => 'required',
            //'jenis_kelamin_masyarakat' => 'required',
            //'alamat_masyarakat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'nik' => $request->nik,
            'nama_masyarakat' => $request->nama_masyarakat,
            'email' => $request->email,
            'telp_masyarakat' => $request->telp_masyarakat,
            'kata_sandi_masyarakat' => Hash::make($request->kata_sandi_masyarakat),
            'tgl_lahir_masyarakat' => $request->tgl_lahir_masyarakat,
            'jenis_kelamin_masyarakat' => $request->jenis_kelamin_masyarakat,
            'alamat_masyarakat' => $request->alamat_masyarakat,
        ];

        if ($request->hasFile('foto_masyarakat')) {
            $foto_masyarakat = $request->file('foto_masyarakat');
            $foto_masyarakat->storeAs('public/masyarakat', $foto_masyarakat->hashName());
            $data['foto_masyarakat'] = $foto_masyarakat->hashName();
        }

        $masyarakat = Masyarakat::create($data);

        return response()->json(['message' => 'Data Masyarakat Berhasil Ditambahkan!', 'data' => $masyarakat], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Masyarakat $masyarakat)
    {
        return new MasyarakatResource(true, 'Data Masyarakat Ditemukan!', $masyarakat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Masyarakat $masyarakat)
    {
        $validator = Validator::make($request->all(), [
            //'nama_masyarakat' => 'required',
            //'email' => 'required|email',
            //'telp_masyarakat' => 'required',
            'foto_masyarakat' => 'image|mimes:jpeg,png,jpg,gif,svg,heic|max:5120',
            //'tgl_lahir_masyarakat' => 'required',
            //'jenis_kelamin_masyarakat' => 'required',
            //'alamat_masyarakat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'nama_masyarakat' => $request->nama_masyarakat,
            'email' => $request->email,
            'telp_masyarakat' => $request->telp_masyarakat,
            'tgl_lahir_masyarakat' => $request->tgl_lahir_masyarakat,
            'jenis_kelamin_masyarakat' => $request->jenis_kelamin_masyarakat,
            'alamat_masyarakat' => $request->alamat_masyarakat,
        ];

        if ($request->filled('kata_sandi_masyarakat')) {
            $data['kata_sandi_masyarakat'] = Hash::make($request->kata_sandi_masyarakat);
        }

        if ($request->hasFile('foto_masyarakat')) {
            $foto_masyarakat = $request->file('foto_masyarakat');
            $foto_masyarakat->storeAs('public/masyarakat', $foto_masyarakat->hashName());

            // Hapus foto lama jika ada
            if ($masyarakat->foto_masyarakat) {
                Storage::delete('public/masyarakat/' . $masyarakat->foto_masyarakat);
            }

            $data['foto_masyarakat'] = $foto_masyarakat->hashName();
        }

        $masyarakat->update($data);

        return new MasyarakatResource(true, 'Data Masyarakat Berhasil Diubah!', $masyarakat);
    }
    /*public function update(Request $request, Masyarakat $masyarakat)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
            'nama_masyarakat' => 'required',
            'email_masyarakat' => 'required',
            'telp_masyarakat' => 'required',
            'foto_masyarakat' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'nik' => $request->nik,
            'nama_masyarakat' => $request->nama_masyarakat,
            'email_masyarakat' => $request->email_masyarakat,
            'telp_masyarakat' => $request->telp_masyarakat,
        ];

        if ($request->filled('kata_sandi_masyarakat')) {
            $data['kata_sandi_masyarakat'] = Hash::make($request->kata_sandi_masyarakat);
        }

        if ($request->hasFile('foto_masyarakat')) {
            $foto_masyarakat = $request->file('foto_masyarakat');
            $foto_masyarakat->storeAs('public/masyarakat', $foto_masyarakat->hashName());

            // Hapus foto lama
            Storage::delete('public/masyarakat/' . $masyarakat->foto_masyarakat);

            $data['foto_masyarakat'] = $foto_masyarakat->hashName();
        }

        $masyarakat->update($data);

        return new MasyarakatResource(true, 'Data Masyarakat Berhasil Diubah!', $masyarakat);
    }*/

    /**
     * Update the specified resource in storage.
     */
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masyarakat $masyarakat)
    {
        $masyarakat->delete();
        return new MasyarakatResource(true, 'Data Masyarakat Berhasil Dihapus!', null);
    }
}
