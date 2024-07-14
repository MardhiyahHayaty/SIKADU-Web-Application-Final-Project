<?php

namespace App\Http\Controllers;

use App\Events\TanggapanBaru;
use App\Events\TanggapanUpdated;
use App\Mail\SendEmail;
use App\Models\LogTanggapan;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TanggapanController extends Controller
{
    public function createOrUpdate(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduans,id',
            'status_pengaduan' => 'required|string',
            'isi_tanggapan' => 'required|string',
            'foto_tanggapan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        Log::info('createOrUpdate called', ['request' => $request->all()]);

        DB::beginTransaction();
        try {
            // Mengambil data pengaduan berdasarkan id
            $pengaduans = Pengaduan::findOrFail($request->id_pengaduan);

            $masyarakat = Masyarakat::where('nik', $pengaduans->nik)->first();
            // Mengambil data tanggapan berdasarkan id_pengaduan
            $tanggapans = Tanggapan::where('id_pengaduan', $request->id_pengaduan)->first();

            if ($tanggapans) {
                Log::info('Tanggapan found', ['tanggapan' => $tanggapans]);

                // Perbarui pengaduan dan tanggapan jika tanggapan sudah ada
                $pengaduans->status_pengaduan = $request->status_pengaduan;
                $pengaduans->save();

                if ($request->hasFile('foto_tanggapan')) {
                    //Storage::delete('public/tanggapan/' . $tanggapans->foto_tanggapan);
                    $foto_tanggapan = $request->file('foto_tanggapan');
                    $foto_tanggapan->storeAs('public/tanggapan', $foto_tanggapan->hashName());
                    $tanggapans->foto_tanggapan = $foto_tanggapan->hashName();
                } else {
                    // Jika tidak ada foto baru diunggah, tetap gunakan foto yang sudah ada
                    $tanggapans->foto_tanggapan = $tanggapans->foto_tanggapan;
                }

                if ($tanggapans->isi_tanggapan !== $request->isi_tanggapan) {
                    $tanggapans->isi_tanggapan = $request->isi_tanggapan;
                }

                $tanggapans->status_tanggapan = $request->status_pengaduan;
                $tanggapans->id_petugas = Auth::guard('admin')->user()->id;
                $tanggapans->tgl_tanggapan = now();
                $tanggapans->save();
                Log::info('Tanggapan updated', ['tanggapan' => $tanggapans]);

                event(new TanggapanUpdated([
                    'status_tanggapan' => $tanggapans->status_tanggapan,
                    'tgl_tanggapan' => Carbon::parse($tanggapans->tgl_tanggapan)->format('d-m-Y H:i:s'),
                    'id_pengaduan' => $tanggapans->id_pengaduan,
                    'nik' => $pengaduans->nik,
                    'message' => 'Tanggapan Anda telah diperbarui'
                ]));
                try {
                    Mail::to($masyarakat->email_masyarakat)->send(new SendEmail($tanggapans, $masyarakat));
                } catch (\Exception $e) {
                    Log::error('Error Send Email', ['error' => $e]);
                }

                DB::commit();
                return response()->json(['message' => 'Berhasil Dikirim!', 'status_pengaduan' => $pengaduans->status_pengaduan], 200);
                // redirect()->route('pengaduan.show', ['pengaduan' => $pengaduans, 'tanggapan' => $tanggapans]);
            } else {
                Log::info('No Tanggapan found, creating new one');

                // Buat tanggapan baru jika belum ada
                $pengaduans->status_pengaduan = $request->status_pengaduan;
                $pengaduans->save();

                $foto_tanggapan = $request->file('foto_tanggapan');
                if ($foto_tanggapan) {
                    $foto_tanggapan->storeAs('public/tanggapan', $foto_tanggapan->hashName());
                }

                $tanggapans = Tanggapan::create([
                    'id_pengaduan' => $request->id_pengaduan,
                    'id_petugas' => Auth::guard('admin')->user()->id,
                    'tgl_tanggapan' => now(),
                    'isi_tanggapan' => $request->isi_tanggapan,
                    'foto_tanggapan' => $foto_tanggapan ? $foto_tanggapan->hashName() : null,
                    'status_tanggapan' => $request->status_pengaduan,
                ]);

                event(new TanggapanBaru([
                    'status_tanggapan' => $tanggapans->status_tanggapan,
                    'tgl_tanggapan' => Carbon::parse($tanggapans->tgl_tanggapan)->format('d-m-Y H:i:s'),
                    'id_pengaduan' => $tanggapans->id_pengaduan,
                    'nik' => $pengaduans->nik,
                    'message' => 'Pengaduan Anda Ditanggapi'
                ]));
                Log::info('Tanggapan created', ['tanggapan' => $tanggapans]);

                try {
                    Mail::to($masyarakat->email_masyarakat)->send(new SendEmail($tanggapans, $masyarakat));
                } catch (\Exception $e) {
                    Log::error('Error Send Email', ['error' => $e]);
                }

                DB::commit();
                return response()->json(['message' => 'Berhasil Dikirim!', 'status_pengaduan' => $pengaduans->status_pengaduan], 200);
            }

            // Redirect ke halaman detail pengaduan
            //return redirect()->route('pengaduan.show', ['pengaduan' => $pengaduans, 'tanggapan' => $tanggapans])->with(['message' => 'Berhasil Dikirim!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in createOrUpdate', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Terjadi kesalahan, silakan coba lagi.'], 500);
            //return redirect()->route('pengaduan.index')->withErrors(['message' => 'Something went wrong, please try again.']);
        }
    }
}
