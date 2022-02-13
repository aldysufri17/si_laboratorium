<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin User
        User::create([
            'name'          => 'Admin',
            'nim'           => '2161312',
            'alamat'        =>   'Semarang',
            'email'         =>  'admin@admin.com',
            'mobile_number' =>  '9028187696',
            'role'          => 'admin',
            'password'      =>  Hash::make('admin'),
        ]);

        // Create Admin User
        User::create([
            'name'          => 'Operator',
            'nim'           => '21131523',
            'alamat'        =>   'Semarang',
            'email'         =>  'operator@admin.com',
            'mobile_number' =>  '9028187696',
            'role'          => 'operator',
            'password'      =>  Hash::make('operator'),
        ]);

        // Create Admin User
         User::create([
            'name'          => 'Peminjam',
            'nim'           => '21131412',
            'alamat'        =>  'Semarang',
            'email'         =>  'peminjam@admin.com',
            'mobile_number' =>  '9028187696',
            'role'          => 'peminjam',
            'password'      =>  Hash::make('peminjam'),
        ]);

    }
}
