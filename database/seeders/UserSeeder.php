<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
            'name'          => 'Peminjam',
            'nim'           => '21131412',
            'laboratorium_id' => 0,
            'alamat'        =>  'Semarang',
            'email'         =>  'peminjam@admin.com',
            'mobile_number' =>  '9028187696',
            'role'       =>  1,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('peminjam'),
        ]);

        $rolePengguna = Role::create(['name' => 'peminjam']);

        $user->assignRole([$rolePengguna->id]);

        // Admin
        $user = User::create([
            'name'          => 'Admin',
            'nim'           => '2161312',
            'laboratorium_id' => 0,
            'alamat'        =>   'Semarang',
            'email'         =>  'admin@admin.com',
            'mobile_number' =>  '9028187696',
            'role'       =>  2,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('admin'),
        ]);

        $roleAdmin = Role::create(['name' => 'admin']);

        $user->assignRole([$roleAdmin->id]);

        // Operator
        $user = User::create([
            'name'          => 'Operator Embedded',
            'nim'           => '211315253',
            'laboratorium_id' => 1,
            'alamat'        =>  'Semarang',
            'email'         =>  'embedded@operator.com',
            'mobile_number' =>  '9028187696',
            'role'       => 3,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('embedded'),
        ]);

        $roleOperator = Role::create(['name' => 'operator']);

        $user->assignRole([$roleOperator->id]);
        $user = User::create([
            'name'          => 'Operator RPL',
            'nim'           => '211315723',
            'laboratorium_id' => 2,
            'alamat'        =>   'Semarang',
            'email'         =>  'rpl@operator.com',
            'mobile_number' =>  '9028187696',
            'role'       => 3,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('rpl'),
        ]);

        // $role = Role::create(['name' => 'operator rpl']);

        $user->assignRole([$roleOperator->id]);
        $user = User::create([
            'name'          => 'Operator Jarkom',
            'nim'           => '211315239',
            'laboratorium_id' => 3,
            'alamat'        =>   'Semarang',
            'email'         =>  'jarkom@operator.com',
            'mobile_number' =>  '9028187696',
            'role'       => 3,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('jarkom'),
        ]);

        // $role = Role::create(['name' => 'operator jarkom']);
        $user->assignRole([$roleOperator->id]);

        // $user->assignRole([$role->id]);
        $user = User::create([
            'name'          => 'Operator Mulmed',
            'nim'           => '211315023',
            'laboratorium_id' => 4,
            'alamat'        =>   'Semarang',
            'email'         =>  'mulmed@operator.com',
            'mobile_number' =>  '9028187696',
            'role'       => 3,
            'status'        =>  1,
            'jk'            => 'L',
            'password'      =>  bcrypt('mulmed'),
        ]);

        // $role = Role::create(['name' => 'operator mulmed']);
        $user->assignRole([$roleOperator->id]);

        // $user->assignRole([$role->id]);
    }
}
