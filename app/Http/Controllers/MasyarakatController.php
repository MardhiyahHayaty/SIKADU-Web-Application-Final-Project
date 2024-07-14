<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    public function index(){
        $masyarakats = Masyarakat::latest()->paginate(10);
        return view('masyarakat.list_masyarakat', compact('masyarakats'));
    }
}
