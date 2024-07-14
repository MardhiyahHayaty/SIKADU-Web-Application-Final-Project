<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/petugasa', \App\Http\Controllers\Api\PetugasController::class);
Route::apiResource('/opds', \App\Http\Controllers\Api\OpdController::class);
Route::apiResource('/masyarakats', \App\Http\Controllers\Api\MasyarakatController::class);
Route::apiResource('/kategoris', \App\Http\Controllers\Api\KategoriController::class);
Route::apiResource('/jenisa', \App\Http\Controllers\Api\JenisController::class);
Route::apiResource('/pemadamans', \App\Http\Controllers\Api\PemadamanController::class);
Route::apiResource('/beritas', \App\Http\Controllers\Api\BeritaController::class);
Route::apiResource('/pengaduans', \App\Http\Controllers\Api\PengaduanController::class);
Route::apiResource('/tanggapans', \App\Http\Controllers\Api\TanggapanController::class);
Route::apiResource('/logTanggapans', \App\Http\Controllers\Api\LogTanggapanController::class);
Route::apiResource('/faqs', \App\Http\Controllers\Api\FaqController::class);
Route::apiResource('/aspirasis', \App\Http\Controllers\Api\AspirasiController::class);

Route::post('login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);

//Route::put('api/petugas/{id}', 'PetugasController@update');
