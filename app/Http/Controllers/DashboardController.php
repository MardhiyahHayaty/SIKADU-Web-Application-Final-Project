<?php

namespace App\Http\Controllers;

use App\Events\PengaduanBaru;
use App\Models\Jenis;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $pengaduans_0 = Pengaduan::where('status_pengaduan', '0')->get()->count();
        $pengaduans_proses = Pengaduan::where('status_pengaduan', 'proses')->get()->count();
        $pengaduans_selesai = Pengaduan::where('status_pengaduan', 'selesai')->get()->count();
        $masyarakat = Masyarakat::all()->count();

        $pengaduans = Pengaduan::join('jenisa', 'jenisa.id', '=', 'pengaduans.id_jenis_aduan')
                ->select('pengaduans.*', 'jenisa.nama_jenis_aduan')
                ->join('masyarakats', 'masyarakats.nik', '=', 'pengaduans.nik')
                ->select('pengaduans.*', 'masyarakats.*')
                ->orderBy('tgl_pengaduan', 'desc')
                ->paginate(10);
        
        $jenisa = Jenis::all();
        $masyarakats = Masyarakat::all();

        $pengaduanPerBulan = DB::table('pengaduans')
            ->select(
                DB::raw("DATE_FORMAT(tgl_pengaduan, '%M %Y') as bulan"),
                DB::raw('count(*) as total_pengaduan')
            )
            ->groupBy(DB::raw("DATE_FORMAT(tgl_pengaduan, '%M %Y')")) // Group by bulan sesuai format
            ->orderByRaw("MIN(tgl_pengaduan)") // Urutkan berdasarkan tanggal terkecil dalam bulan
            ->get();

        $pengaduanPerJenis = DB::table('pengaduans')
            ->join('jenisa', 'pengaduans.id_jenis_aduan', '=', 'jenisa.id')
            ->select('jenisa.nama_jenis_aduan', DB::raw('count(*) as total_pengaduan'))
            ->groupBy('jenisa.nama_jenis_aduan')
            ->orderBy('total_pengaduan', 'desc')
            ->get();
        
        // Ambil semua data pengaduan
        $peta_pengaduans = Cache::remember('peta_pengaduans', now()->addMinutes(30), function () {
            return Pengaduan::select('lokasi_pengaduan')->get()->map(function ($pengaduan) {
                $coordinates = explode(',', $pengaduan->lokasi_pengaduan);
                return [
                    'latitude' => $coordinates[0],
                    'longitude' => $coordinates[1],
                    'locationName' => $this->getLocationName($coordinates[0], $coordinates[1])
                ];
            });
        });

        //KPI Rata-Rata Waktu Penyelesaian Pengaduan
        // Ambil pengaduan yang sudah ditanggapi dengan status 'selesai'
        $tanggapanSelesai = Tanggapan::where('status_tanggapan', 'selesai')->get();

        $totalDurasiPenyelesaian = 0;
        $jumlahPengaduanSelesai = $tanggapanSelesai->count();

        foreach ($tanggapanSelesai as $tanggapan) {
            $pengaduan = $tanggapan->pengaduan; // Asumsi relasi sudah terdefinisi di model Tanggapan
            if ($pengaduan) {
                $tanggalPengaduan = Carbon::parse($pengaduan->tgl_pengaduan);
                $tanggalTanggapan = Carbon::parse($tanggapan->tgl_tanggapan);

                // Hitung durasi dalam hari
                $durasiPenyelesaian = $tanggalTanggapan->diffInDays($tanggalPengaduan);
                $totalDurasiPenyelesaian += $durasiPenyelesaian;
            }
        }

        $waktuRataRataPenyelesaian = $jumlahPengaduanSelesai > 0 ? ceil($totalDurasiPenyelesaian / $jumlahPengaduanSelesai) : 0;
        
        return view('dashboard.dashboard', compact('pengaduans_0', 'pengaduans_proses', 'pengaduans_selesai', 'masyarakat', 'pengaduans', 'jenisa', 'masyarakats', 'pengaduanPerBulan', 'pengaduanPerJenis', 'peta_pengaduans', 'waktuRataRataPenyelesaian'));
    }

    private function getLocationName($latitude, $longitude)
    {
        $cacheKey = "location_name_{$latitude}_{$longitude}";
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($latitude, $longitude) {
            $response = Http::get("https://nominatim.openstreetmap.org/reverse", [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
            ]);

            $data = $response->json();
            return $data['display_name'] ?? 'Unknown Location';
        });
    }

    /*private function getLocationName($latitude, $longitude)
    {
        $response = Http::get("https://nominatim.openstreetmap.org/reverse", [
            'lat' => $latitude,
            'lon' => $longitude,
            'format' => 'json',
        ]);

        $data = $response->json();

        return $data['display_name'] ?? 'Unknown Location';
    }*/

    public function tesnotif()
    {
        event(new PengaduanBaru('Latihan Pusher'));
    }
}
