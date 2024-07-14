<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogTanggapanResource;
use App\Models\LogTanggapan;
use Illuminate\Http\Request;

class LogTanggapanController extends Controller
{
    public function index()
    {
        $logTanggapan = LogTanggapan::with('tanggapan', 'pengaduan', 'petugas')->paginate(100);
        return new LogTanggapanResource(true, 'List Data Log Tanggapan', $logTanggapan);
    }

    public function show(LogTanggapan $logTanggapan)
    {
        return new LogTanggapanResource(true, 'Data Log Tanggapan Ditemukan!', $logTanggapan);
    }
}
