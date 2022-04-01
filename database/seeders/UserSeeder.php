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
        // Peminjam
        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 0, 8),
            'name'          => 'Peminjam',
            'nim'           => '21131412',
            'alamat'        =>  'Semarang',
            'email'         =>  'peminjam@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'       =>  1,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('peminjam'),
        ]);

        $role = Role::create(['name' => 'peminjam']);

        $user->assignRole([$role->id]);

        // Admin
        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => 'Admin',
            'nim'           => '2161312',
            'alamat'        =>   'Semarang',
            'email'         =>  'admin@admin.com',
            'mobile_number' =>  '9028187696',
            'role_id'       =>  2,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('admin'),
        ]);

        $role = Role::create(['name' => 'admin']);

        $user->assignRole([$role->id]);

        // Operator
        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => 'Operator Embedded',
            'nim'           => '211315253',
            'alamat'        =>  'Semarang',
            'email'         =>  'embedded@operator.com',
            'mobile_number' =>  '9028187696',
            'role_id'       => 3,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('embedded'),
        ]);

        $role = Role::create(['name' => 'operator embedded']);

        $user->assignRole([$role->id]);
        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => 'Operator RPL',
            'nim'           => '211315723',
            'alamat'        =>   'Semarang',
            'email'         =>  'rpl@operator.com',
            'mobile_number' =>  '9028187696',
            'role_id'       => 4,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('rpl'),
        ]);

        $role = Role::create(['name' => 'operator rpl']);

        $user->assignRole([$role->id]);
        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => 'Operator Jarkom',
            'nim'           => '211315239',
            'alamat'        =>   'Semarang',
            'email'         =>  'jarkom@operator.com',
            'mobile_number' =>  '9028187696',
            'role_id'       => 5,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('jarkom'),
        ]);

        $role = Role::create(['name' => 'operator jarkom']);

        $user->assignRole([$role->id]);
        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => 'Operator Mulmed',
            'nim'           => '211315023',
            'alamat'        =>   'Semarang',
            'email'         =>  'mulmed@operator.com',
            'mobile_number' =>  '9028187696',
            'role_id'       => 6,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('mulmed'),
        ]);

        $role = Role::create(['name' => 'operator mulmed']);

        $user->assignRole([$role->id]);
    }
}
