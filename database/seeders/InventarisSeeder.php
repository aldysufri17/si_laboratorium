<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Inventaris;
use Illuminate\Database\Seeder;

class InventarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barang = Barang::pluck('stock');
        // $lab = Barang::pluck('kategori_lab');
        $id_id = Barang::pluck('id');
        foreach ($id_id as $index => $value) {
            // Mutasi
            $random = date('dmY') . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
            Inventaris::create([
                'barang_id'         => $value,
                'status'            => 1,
                'deskripsi'         => 'Baru',
                'kode_mutasi'       => 'IN' . $random,
                'kode_inventaris'   => 'IN' . $random,
                'masuk'             => $barang[$index],
                // 'kategori_lab'      => $lab[$index],
                'keluar'            => 0,
                'total_mutasi'      => $barang[$index],
                'total_inventaris'  => 0,
            ]);

            // Inventaris
            if (strlen($value) == 1) {
                $kode = "000" . $value;
            } else if (strlen($value) == 2) {
                $kode = "00" . $value;
            } else if (strlen($value) == 3) {
                $kode = "0" . $value;
            } else {
                $kode = $value;
            }
            $Date = date("Y/m/d");
            $year = date('Y', strtotime($Date));
            $num = $value + 2;

            Inventaris::create([
                'barang_id'         => $value,
                'status'            => 2,
                'deskripsi'         => 'Created',
                'kode_mutasi'       => 'Kosong',
                'kode_inventaris'   => $kode . '.' . $value . '.' . $num . '.' . $year,
                'masuk'             => 0,
                // 'kategori_lab'      => $lab[$index],
                'keluar'            => 0,
                'total_inventaris'              => $barang[$index]
            ]);
        }
    }
}
