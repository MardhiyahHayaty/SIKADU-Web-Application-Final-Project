<?php

namespace App\Http\Controllers\Api;

use App\Events\TanggapanBaru;
use App\Events\TanggapanUpdated;
use App\Models\Tanggapan;
use App\Http\Resources\TanggapanResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tanggapan = Tanggapan::with('pengaduan', 'petugas')->paginate(100);
        return new TanggapanResource(true, 'List Data Tanggapan', $tanggapan);
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
            'id_pengaduan'=> 'required',
            //'id_petugas' => 'required',
            //'tgl_tanggapan' => 'required',
            'isi_tanggapan' => 'required',
            'foto_tanggapan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status_tanggapan' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto_tanggapan = $request->file('foto_tanggapan');
        $foto_tanggapan->storeAs('public/tanggapan', $foto_tanggapan->hashName());

        $tanggapan = Tanggapan::create([
            'id_pengaduan' => $request->id_pengaduan,
            'id_petugas' => Auth::guard('admin')->user()->id, /*$request->id_petugas,*/
            'tgl_tanggapan' => date('Y-m-d H:i:s'),
            'isi_tanggapan' => $request->isi_tanggapan,
            'foto_tanggapan' => $foto_tanggapan->hashName(),
            'status_tanggapan' => $request->status_tanggapan,
        ]);

        $pengaduan = $tanggapan->pengaduan()->first();
        $nik = $pengaduan->nik;

        $tanggapanSend = [
            'status_tanggapan' => $tanggapan->status_tanggapan,
            'tgl_tanggapan' => $tanggapan->tgl_tanggapan,
            'id_pengaduan' => $tanggapan->id_pengaduan,
            'nik' => $nik,
            'message' => 'Pengaduan Anda Ditanggapi'
        ];

        event(new TanggapanBaru($tanggapanSend));

        return new TanggapanResource(true, 'Data Tanggapan Berhasil Ditambahkan!', $tanggapan);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Tanggapan $tanggapan)
    {
        return new TanggapanResource(true, 'Data Tanggapan Ditemukan!', $tanggapan);
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
    public function update(Request $request, Tanggapan $tanggapan)
    {
        $validator = Validator::make($request->all(), [
            'id_pengaduan'=> 'required',
            //'id_petugas' => 'required',
            //'tgl_tanggapan' => 'required',
            'isi_tanggapan' => 'required',
            'foto_tanggapan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status_tanggapan' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('foto_tanggapan')){

            $foto_tanggapan = $request->file('foto_tanggapan');
            $foto_tanggapan -> storeAs('public/tanggapan', $foto_tanggapan->hashName());

            Storage::delete('public/tanggapan/'.$tanggapan->foto_tanggapan);

            $tanggapan->update([
                'id_pengaduan' => $request->id_pengaduan,
                'id_petugas' => Auth::guard('admin')->user()->id, /*$request->id_petugas,*/
                'tgl_tanggapan' => date('Y-m-d H:i:s'),
                'isi_tanggapan' => $request->isi_tanggapan,
                'foto_tanggapan' => $foto_tanggapan->hashName(),
                'status_tanggapan' => $request->status_tanggapan,
            ]);
        } else {

            $tanggapan->update([
                'id_pengaduan' => $request->id_pengaduan,
                'id_petugas' => Auth::guard('admin')->user()->id, /*$request->id_petugas,*/
                'tgl_tanggapan' => date('Y-m-d H:i:s'),
                'isi_tanggapan' => $request->isi_tanggapan,
                //'foto_tanggapan' => $foto_tanggapan->hashName(),
                'status_tanggapan' => $request->status_tanggapan,
            ]);
        }

        $pengaduan = $tanggapan->pengaduan()->first();
        $nik = $pengaduan->nik;

        $tanggapanSend = [
            'status_tanggapan' => $tanggapan->status_tanggapan,
            'tgl_tanggapan' => $tanggapan->tgl_tanggapan,
            'id_pengaduan' => $tanggapan->id_pengaduan,
            'nik' => $nik,
            'message' => 'Tanggapan Anda telah diperbarui '
        ];

        event(new TanggapanUpdated($tanggapanSend));

        return new TanggapanResource(true, 'Data Tanggapan Berhasil Diubah!', $tanggapan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tanggapan $tanggapan)
    {
        $tanggapan->delete();
        return new TanggapanResource(true, 'Data Tanggapan Berhasil Dihapus!', null);
    }
}
