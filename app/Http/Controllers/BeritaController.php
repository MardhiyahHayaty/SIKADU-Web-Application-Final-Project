<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Petugas;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(){
        $beritas = Berita::join('petugasa', 'petugasa.id', '=', 'beritas.id_petugas')
                ->select('beritas.*', 'petugasa.nama_petugas')
                ->latest()->paginate(10);
        
        $petugasa = Petugas::all();

        return view('berita.list_berita', compact('petugasa', 'beritas'));
        
        /*$petugasa = Petugas::latest()->paginate(10);
        return view('petugas.list_petugas', compact('petugasa'));*/
    }

}
