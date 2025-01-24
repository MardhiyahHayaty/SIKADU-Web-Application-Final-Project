<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rating = Rating::with('pengaduan')->paginate(100);
        return new RatingResource(true, 'List Rating', $rating);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pengaduan'=> 'required',
            'nilai' => 'required',
            'pesan'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rating = Rating::create([
            'id_pengaduan' => $request->id_pengaduan,
            'nilai' => $request->nilai,
            'pesan' => $request->pesan,
        ]);

        return new RatingResource(true, 'Data Rating Berhasil Ditambahkan!', $rating);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        return new RatingResource(true, 'Data Rating Ditemukan!', $rating);
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
    public function update(Request $request, Rating $rating)
    {
        $validator = Validator::make($request->all(), [
            'id_pengaduan' => 'required',
            'nilai' => 'required',
            'pesan' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $rating->update([
            'id_pengaduan' => $request->id_pengaduan,
            'nilai' => $request->nilai,
            'pesan' => $request->pesan,
        ]);

        return new RatingResource(true, 'Data Rating Berhasil Diubah!', $rating);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return new RatingResource(true, 'Data Rating Berhasil Dihapus!', null);
    }
}
