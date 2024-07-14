<?php

namespace App\Http\Controllers\Api;

use App\Events\PengaduanBaru;
use App\Models\Pengaduan;
use App\Http\Resources\PengaduanResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengaduan = Pengaduan::with('masyarakat', 'jenis')->paginate(100);
        return new PengaduanResource(true, 'List Data Pengaduan', $pengaduan);
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
            //'tgl_pengaduan' => 'required',
            //'jenis_pengaduan' => 'required',
            'id_jenis_aduan' => 'required',
            'permasalahan' => 'required',
            'keterangan' => 'required',
            'lokasi_pengaduan' => 'required',
            'foto_pengaduan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            //'status_pengaduan' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto_pengaduan = $request->file('foto_pengaduan');
        $foto_pengaduan->storeAs('public/pengaduan', $foto_pengaduan->hashName());

        date_default_timezone_set('Asia/Jakarta');

        $pengaduan = Pengaduan::create([
            'nik' => $request->nik,
            'tgl_pengaduan' => date('Y-m-d H:i:s'),
            'jenis_pengaduan' => $request->jenis_pengaduan,
            'id_jenis_aduan' => $request->id_jenis_aduan,
            'permasalahan' => $request->permasalahan,
            'keterangan' => $request->keterangan,
            'lokasi_pengaduan' => $request->lokasi_pengaduan,
            'foto_pengaduan' => $foto_pengaduan->hashName(),
            'status_pengaduan' => '0',
        ]);

        $pengaduanSend = [
            'permasalahan' => $pengaduan->permasalahan,
            'id_jenis_aduan' => $pengaduan->id_jenis_aduan,
            'tgl_pengaduan' => $pengaduan->tgl_pengaduan, 
            'message' => 'Pengaduan Baru Telah Masuk!! '
        ];

        Log::info('Memicu event PengaduanBaru untuk ID: ' . $pengaduan->id);
        // Trigger the event
        event(new PengaduanBaru($pengaduanSend));

        return new PengaduanResource(true, 'Data Pengaduan Berhasil Ditambahkan!', $pengaduan);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        return new PengaduanResource(true, 'Data Pengaduan Ditemukan!', $pengaduan);
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
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validator = Validator::make($request->all(), [
            'nik'=> 'required',
            //'tgl_pengaduan' => 'required',
            //'jenis_pengaduan' => 'required',
            //'id_jenis_aduan' => 'required',
            'permasalahan' => 'required',
            'keterangan' => 'required',
            'lokasi_pengaduan' => 'required',
            'foto_pengaduan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            //'status_pengaduan' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('foto_pengaduan')){

            $foto_pengaduan = $request->file('foto_pengaduan');
            $foto_pengaduan -> storeAs('public/pengaduan', $foto_pengaduan->hashName());

            Storage::delete('public/pengaduan/'.$pengaduan->foto_pengaduan);

            $pengaduan->update([
                'nik' => $request->nik,
                'tgl_pengaduan' => $request->tgl_pengaduan,
                'jenis_pengaduan' => $request->jenis_pengaduan,
                //'id_jenis_aduan' => $request->id_jenis_aduan,
                'permasalahan' => $request->permasalahan,
                'keterangan' => $request->keterangan,
                'lokasi_pengaduan' => $request->lokasi_pengaduan,
                'foto_pengaduan' => $foto_pengaduan->hashName(),
                'status_pengaduan' => $request->status_pengaduan,
            ]);
        } else {

            $pengaduan->update([
                'nik' => $request->nik,
                'tgl_pengaduan' => $request->tgl_pengaduan,
                'jenis_pengaduan' => $request->jenis_pengaduan,
                'id_jenis_aduan' => $request->id_jenis_aduan,
                'permasalahan' => $request->permasalahan,
                'keterangan' => $request->keterangan,
                'lokasi_pengaduan' => $request->lokasi_pengaduan,
                //'foto_pengaduan' => $foto_pengaduan->hashName(),
                'status_pengaduan' => $request->status_pengaduan,
            ]);
        }

        return new PengaduanResource(true, 'Data Pengaduan Berhasil Diubah!', $pengaduan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();
        return new PengaduanResource(true, 'Data Pengaduan Berhasil Dihapus!', null);
    }
}
