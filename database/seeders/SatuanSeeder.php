<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Satuan::create([
            'id'    => 1,
            "kode" => 'ST-0001',
            "nama_satuan" => 'UNIT',
            "kategori_lab" => 1,
        ]);
        Satuan::create([
            'id'    => 2,
            "kode" => 'ST-0002',
            "nama_satuan" => 'PCS',
            "kategori_lab" => 1,
        ]);
        Satuan::create([
            'id'    => 3,
            "kode" => 'ST-0003',
            "nama_satuan" => 'UNIT',
            "kategori_lab" => 2,
        ]);
        Satuan::create([
            'id'    => 4,
            "kode" => 'ST-0004',
            "nama_satuan" => 'UNIT',
            "kategori_lab" => 3,
        ]);
        Satuan::create([
            'id'    => 5,
            "kode" => 'ST-0005',
            "nama_satuan" => 'UNIT',
            "kategori_lab" => 4,
        ]);
    }
}
