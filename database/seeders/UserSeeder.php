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
        $user = User::create([
            'name'          => 'Admin',
            'nim'           => '211312',
            'alamat'        =>   'Semarang',
            'email'         =>  'admin@admin.com',
            'mobile_number' =>  '9028187696',
            'password'      =>  Hash::make('admin'),
            'role_id'       => 1
        ]);
    }
}
