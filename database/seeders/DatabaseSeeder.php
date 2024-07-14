<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Petugas::create([
            'nip_petugas' => '14567899008766',
            'nama_petugas' => 'Administrator',
            'email_petugas' => 'admin@gmail.com',
            'telp_petugas' => '081265556677',
            'id_opd' => '1',
            'kata_sandi_petugas' => Hash::make('adminsikadu'),
            'foto_petugas' => ' ',
            'level' => 'admin',
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
