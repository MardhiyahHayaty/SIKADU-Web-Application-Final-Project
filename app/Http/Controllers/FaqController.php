<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){
        $faqs = Faq::latest()->paginate(10);
        return view('faq.list_faq', compact('faqs'));
    }
}
