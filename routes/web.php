<?php

use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordMasyarakatController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ResetPasswordMasyarakatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/kategori', [\App\Http\Controllers\KategoriController::class, 'index']);

Route::middleware(['isAdmin'])->group(function() {
    //Kategori Aduan
    Route::get('/jenis', [\App\Http\Controllers\JenisController::class, 'index']);

    //Data Petugas
    Route::get('/petugas', [\App\Http\Controllers\PetugasController::class, 'index']);

    //Data Masyarakat
    Route::get('/masyarakat', [\App\Http\Controllers\MasyarakatController::class, 'index']);

    //Data FAQ
    Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index']);

    //Live Chat
    Route::get('/chats', [\App\Http\Controllers\AdminChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{userId}', [AdminChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/reply', [AdminChatController::class, 'reply'])->name('chats.reply');
});

Route::middleware(['isSatgas'])->group(function () {
    //Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

    //Pengaduan
    Route::get('/pengaduan', [\App\Http\Controllers\PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/filter', [PengaduanController::class, 'filter'])->name('pengaduan.filter');
    Route::post('/tanggapan/createOrUpdate', [TanggapanController::class, 'createOrUpdate'])->name('tanggapan.createOrUpdate');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');

    //Aspirasi
    Route::get('/aspirasi', [\App\Http\Controllers\AspirasiController::class, 'index']);
    Route::get('/aspirasi/{id}', [\App\Http\Controllers\AspirasiController::class, 'show']);


    //Informasi Pemadaman Listrik
    Route::get('/pemadaman', [\App\Http\Controllers\PemadamanController::class, 'index']);

    //Berita
    Route::get('/berita', [\App\Http\Controllers\BeritaController::class, 'index']);

    //Profil
    Route::get('/profile', [PetugasController::class, 'showProfile'])->name('petugas.profile.show');
    Route::put('/petugas/profile/update/{id}', [PetugasController::class, 'update'])->name('petugas.profile.update');
    Route::post('/petugas/update-password', [PetugasController::class, 'updatePassword'])->name('petugas.updatePassword');

    //Notifikasi
    Route::get('tesnotif', [DashboardController::class, 'tesnotif']);

    Route::get('/grafik-pengaduan', [PengaduanController::class, 'grafikPengaduan']);

    //Logout
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['isGuest'])->group(function () {
    Route::get('/admin', [AdminController::class, 'formLogin'])->name('admin.formLogin');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    //Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    //Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::post('forgot-password', [ForgotPasswordMasyarakatController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('reset-password', [ResetPasswordMasyarakatController::class, 'reset'])->name('password.update');
    
});





