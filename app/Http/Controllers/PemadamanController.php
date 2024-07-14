<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemadaman;
use App\Models\Petugas;

class PemadamanController extends Controller
{
    public function index(){
        $pemadamans = Pemadaman::join('petugasa', 'petugasa.id', '=', 'pemadamen.id_petugas')
                ->select('pemadamen.*', 'petugasa.nama_petugas')
                ->latest()->paginate(10);
        
        $petugasa = Petugas::all();

        return view('pemadaman.list_pemadaman', compact('petugasa', 'pemadamans'));
        /*$pemadamans = Pemadaman::latest()->paginate(10);
        return view('pemadaman.list_pemadaman', compact('pemadamans'));*/
    }
}
