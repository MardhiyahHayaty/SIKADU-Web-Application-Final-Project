<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Opd;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index(){
        $jenisa = Jenis::join('kategoris', 'kategoris.id', '=', 'jenisa.id_kategori')
                ->select('jenisa.*', 'kategoris.nama_kategori')
                ->join('opds', 'opds.id', '=', 'jenisa.id_opd')
                ->select('jenisa.*', 'opds.nama_opd')
                ->latest()->paginate(10);
        
        $kategoris = Kategori::all();
        $opds = Opd::all();

        return view('jenis.list_jenis', compact('jenisa', 'kategoris', 'opds'));
    }
    
}
