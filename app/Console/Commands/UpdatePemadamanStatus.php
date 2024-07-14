<?php

namespace App\Console\Commands;

use App\Models\Pemadaman;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePemadamanStatus extends Command
{

    protected $signature = 'update:pemadaman-status';
    protected $description = 'Update status pemadaman based on the current date and time';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        // Update status to 'berlangsung' for pemadaman happening now
        Pemadaman::whereDate('tgl_mulai_pemadaman', $now->setTimezone('Asia/Jakarta')->toDateString())
            ->whereTime('jam_mulai_pemadaman', '<=', $now->setTimezone('Asia/Jakarta')->toTimeString())
            ->whereTime('jam_selesai_pemadaman', '>=', $now->setTimezone('Asia/Jakarta')->toTimeString())
            ->update(['status_pemadaman' => 'Berlangsung']);

        // Update status to 'selesai' for pemadaman that have ended
        Pemadaman::where(function ($query) use ($now) {
            $query->whereDate('tgl_mulai_pemadaman', '<', $now->setTimezone('Asia/Jakarta')->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->whereDate('tgl_mulai_pemadaman', $now->setTimezone('Asia/Jakarta')->toDateString())
                        ->whereTime('jam_selesai_pemadaman', '<', $now->setTimezone('Asia/Jakarta')->toTimeString());
                });
        })->update(['status_pemadaman' => 'Selesai']);

        // Update status to 'mendatang' for pemadaman starting in the future
        Pemadaman::where(function ($query) use ($now) {
            $query->whereDate('tgl_mulai_pemadaman', '>', $now->setTimezone('Asia/Jakarta')->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->whereDate('tgl_mulai_pemadaman', $now->setTimezone('Asia/Jakarta')->toDateString())
                        ->whereTime('jam_mulai_pemadaman', '>', $now->setTimezone('Asia/Jakarta')->toTimeString());
                });
        })->update(['status_pemadaman' => 'Mendatang']);

        $this->info('Status pemadaman updated successfully');
    }
}
