<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $operator = Role::create([
            'name' => 'operator',
            'guard_name' => 'web',
        ]);

        $peminjam = Role::create([
            'name' => 'peminjam',
            'guard_name' => 'web',
        ]);

    }
}
