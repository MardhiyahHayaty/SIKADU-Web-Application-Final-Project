<?php

namespace App\Http\Controllers;

use App\Events\PengaduanBaru;
use App\Models\Jenis;
use App\Models\LogTanggapan;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PengaduanController extends Controller
{
    public function index(Request $request){
        $query = Pengaduan::with(['jenis', 'masyarakat'])->orderBy('tgl_pengaduan', 'desc');

        // Filter by status
        if ($request->has('status_pengaduan')) {
            $statusPengaduan = $request->input('status_pengaduan');
            if ($statusPengaduan !== 'all') {
                $query->where('status_pengaduan', $statusPengaduan);
            }
        }

        // Apply date filters if provided
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = date('Y-m-d', strtotime($request->input('to_date') . ' +1 day')); // Tambah 1 hari untuk memasukkan seluruh hari 'to_date'
            $query->whereBetween('tgl_pengaduan', [$fromDate, $toDate]);
        }

        $pengaduans = $query->paginate(10);

        foreach ($pengaduans as $pengaduan) {
            $coords = explode(',', $pengaduan->lokasi_pengaduan);
            $latitude = $coords[0];
            $longitude = $coords[1];
            $pengaduan->lokasi_pengaduan = $this->getLocationName($latitude, $longitude);
        }

        return view('pengaduan.list_pengaduan', compact('pengaduans'));
        /*$pemadamans = Pemadaman::latest()->paginate(10);
        return view('pemadaman.list_pemadaman', compact('pemadamans'));*/
    }

    /*public function filter(Request $request)
    {
        $status_pengaduan = $request->query('status_pengaduan');

        $pengaduans = Pengaduan::with(['jenis', 'masyarakat'])
            ->where('status_pengaduan', $status_pengaduan)
            ->orderBy('tgl_pengaduan', 'desc')
            ->paginate(10);
        
        foreach ($pengaduans as $pengaduan) {
            $coords = explode(',', $pengaduan->lokasi_pengaduan);
            $latitude = $coords[0];
            $longitude = $coords[1];
            $pengaduan->lokasi_pengaduan = $this->getLocationName($latitude, $longitude);
        }

        return view('pengaduan.list_pengaduan', compact('pengaduans'));
    }*/

    // Fungsi untuk mendapatkan nama lokasi dari latitude dan longitude
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

    public function show($id){
        $pengaduans = Pengaduan::where('id', $id)->first();

        $tanggapans = Tanggapan::where('id_pengaduan', $id)->first();

        // Mengambil data log tanggapan berdasarkan id_tanggapan jika ada tanggapans
        $logTanggapans = $tanggapans ? LogTanggapan::where('id_tanggapan', $tanggapans->id)->orderBy('tgl_tanggapan', 'desc')->get() : collect([]);

        $latitude = explode(',', $pengaduans->lokasi_pengaduan)[0];
        $longitude = explode(',', $pengaduans->lokasi_pengaduan)[1];
        $locationName = $this->getLocationName($latitude, $longitude);

        return view('pengaduan.detail_pengaduan', compact('pengaduans', 'tanggapans', 'logTanggapans', 'latitude', 'longitude', 'locationName'));
    }

    /*public function store(Request $request)
    {
        $pengaduan = Pengaduan::create($request->all());

        // Trigger event
        event(new PengaduanBaru($pengaduan));

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }*/

}
