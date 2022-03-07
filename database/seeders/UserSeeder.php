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
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => 'Admin',
            'nim'           => '2161312',
            'alamat'        =>   'Semarang',
            'email'         =>  'admin@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'       =>  1,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('admin'),
        ]);

        $role = Role::create(['name' => 'admin']);

        $user->assignRole([$role->id]);

        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => 'Operator',
            'nim'           => '21131523',
            'alamat'        =>   'Semarang',
            'email'         =>  'operator@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'       => 2,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('operator'),
        ]);

        $role = Role::create(['name' => 'operator']);

        $user->assignRole([$role->id]);

        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'name'          => 'Peminjam',
            'nim'           => '21131412',
            'alamat'        =>  'Semarang',
            'email'         =>  'peminjam@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'          => 3,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('peminjam'),
        ]);

        $role = Role::create(['name' => 'peminjam']);

        $user->assignRole([$role->id]);
    }
}
