<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlasifikasiPelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('klasifikasi_pelayanans')->insert([
            [
                'nama_klasifikasi' => 'Pelayanan Statistik Terpadu (PST)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_klasifikasi' => 'Layanan PPID',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
