<?php

namespace Database\Seeders;

use App\Models\Laboratorium;
use Illuminate\Database\Seeder;

class LaboratoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Laboratorium::create([
            'nama' => 'Laboratorium Sistem Tertanam dan Robotika',
            'kode' => 'EM'
        ]);
        Laboratorium::create([
            'nama' => 'Laboratorium Rekayasa Perangkat Lunak',
            'kode' => 'PL'
        ]);
        Laboratorium::create([
            'nama' => 'Laboratorium Jaringan dan Keamanan Komputer',
            'kode' => 'JK'
        ]);
        Laboratorium::create([
            'nama' => 'Laboratorium Multimedia',
            'kode' => 'ME'
        ]);
    }
}
