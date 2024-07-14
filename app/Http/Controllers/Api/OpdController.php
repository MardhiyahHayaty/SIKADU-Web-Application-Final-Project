<?php

namespace App\Http\Controllers\Api;

use App\Models\Opd;
use App\Http\Resources\OpdResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opds = Opd::latest()->paginate(100);
        return new OpdResource(true, 'List Data OPD', $opds);
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
    public function store(Request $request)  //Insert data
    {
        $validator = Validator::make($request->all(),[
            'nama_opd' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $opd = Opd::create([
            'nama_opd' => $request->nama_opd,
        ]);

        return new OpdResource(true, 'Data OPD Berhasil Ditambahkan!', $opd);
    }

    /**
     * Display the specified resource.
     */
    public function show(Opd $opd)
    {
        return new OpdResource(true, 'Data OPD Ditemukan!', $opd);
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
    public function update(Request $request, Opd $opd)
    {
        $validator = Validator::make($request->all(), [
            'nama_opd' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $opd->update([
            'nama_opd' => $request->nama_opd,
        ]);

        return new OpdResource(true, 'Data OPD Berhasil Diubah!', $opd);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opd $opd)
    {
        $opd->delete();
        return new OpdResource(true, 'Data Opd Berhasil Dihapus!', null);
    }
}
