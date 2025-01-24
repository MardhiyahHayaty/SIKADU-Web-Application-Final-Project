<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Jenis;
use App\Models\Masyarakat;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index(){
        $aspirasis = Aspirasi::with(['jenis.opd', 'masyarakat'])
            ->orderBy('tgl_aspirasi', 'desc')
            ->paginate(10);

        $jenisa = Jenis::all();
        $masyarakats = Masyarakat::all();

        return view('aspirasi.list_aspirasi', compact('aspirasis', 'jenisa', 'masyarakats'));
    }

    public function show($id)
    {
        $aspirasi = Aspirasi::with(['jenis.opd'])->findOrFail($id);
        return response()->json($aspirasi);
    }

    public function search(Request $request)
{
    $search = $request->query('search');
    $aspirasis = Aspirasi::where('judul_aspirasi', 'LIKE', "%{$search}%")
        ->orWhere('nik', 'LIKE', "%{$search}%")
        ->paginate(10);

    return view('aspirasi.index', compact('aspirasis'));
}

}
