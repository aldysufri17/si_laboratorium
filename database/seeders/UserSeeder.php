<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

        $user = User::create([
            'name'          => 'Admin',
            'nim'           => '2161312',
            'alamat'        =>   'Semarang',
            'email'         =>  'admin@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'       =>  1,
            'status'        =>  1,
            'password'      =>  bcrypt('admin'),
        ]);

        $role = Role::create(['name' => 'admin']);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name'          => 'Operator',
            'nim'           => '21131523',
            'alamat'        =>   'Semarang',
            'email'         =>  'operator@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'       => 2,
            'status'        =>  1,
            'password'      =>  bcrypt('operator'),
        ]);

        $role = Role::create(['name' => 'operator']);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name'          => 'Peminjam',
            'nim'           => '21131412',
            'alamat'        =>  'Semarang',
            'email'         =>  'peminjam@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'          => 3,
            'status'        =>  1,
            'password'      =>  bcrypt('peminjam'),
        ]);

        $role = Role::create(['name' => 'peminjam']);

        $user->assignRole([$role->id]);
    }
}
