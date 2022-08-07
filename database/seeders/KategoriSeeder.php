<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'id'    => 1,
            "kode" => 'KT-0001',
            "nama_kategori" => 'Komponen',
            "laboratorium_id" => 1,
        ]);
        Kategori::create([
            'id'    => 2,
            "kode" => 'KT-0002',
            "nama_kategori" => 'Alat',
            "laboratorium_id" => 1,
        ]);
        Kategori::create([
            'id'    => 3,
            "kode" => 'KT-0003',
            "nama_kategori" => 'Bahan',
            "laboratorium_id" => 1,
        ]);

        Kategori::create([
            'id'    => 4,
            "kode" => 'KT-0004',
            "nama_kategori" => 'Alat',
            "laboratorium_id" => 2,
        ]);
        Kategori::create([
            'id'    => 5,
            "kode" => 'KT-0005',
            "nama_kategori" => 'Bahan',
            "laboratorium_id" => 2,
        ]);
        Kategori::create([
            'id'    => 6,
            "kode" => 'KT-0006',
            "nama_kategori" => 'Alat',
            "laboratorium_id" => 3,
        ]);
        Kategori::create([
            'id'    => 7,
            "kode" => 'KT-0007',
            "nama_kategori" => 'Bahan',
            "laboratorium_id" => 3,
        ]);
        Kategori::create([
            'id'    => 8,
            "kode" => 'KT-0008',
            "nama_kategori" => 'Alat',
            "laboratorium_id" => 4,
        ]);
        Kategori::create([
            'id'    => 9,
            "kode" => 'KT-0009',
            "nama_kategori" => 'Bahan',
            "laboratorium_id" => 4,
        ]);
    }
}
