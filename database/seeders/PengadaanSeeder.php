<?php

namespace Database\Seeders;

use App\Models\Pengadaan;
use Illuminate\Database\Seeder;

class PengadaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pengadaan::create([
            'id'    => 1,
            "kode" => 'TK-0001',
            "nama_pengadaan" => 'Barang Inventaris',
        ]);
        Pengadaan::create([
            'id'    => 2,
            "kode" => 'TK-0002',
            "nama_pengadaan" => 'Barang Habis Pakai',
        ]);
        Pengadaan::create([
            'id'    => 3,
            "kode" => 'TK-0003',
            "nama_pengadaan" => 'Barang Hibah',
        ]);
        Pengadaan::create([
            'id'    => 4,
            "kode" => 'TK-0004',
            "nama_pengadaan" => 'Barang Laboratorium',
        ]);
    }
}
