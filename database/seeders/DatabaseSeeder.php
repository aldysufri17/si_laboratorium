<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SatuanSeeder::class,
            KategoriSeeder::class,
            BarangSeeder::class,
            PengadaanSeeder::class,
            InventarisSeeder::class
        ]);
    }
}
