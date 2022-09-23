<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::create([
            'nim'           => $row[0],
            'name'          => $row[1],
            'email'         => $row[2],
            'alamat'        => $row[3],
            'jk'            => $row[4],
            'mobile_number' => $row[5],
            'post'          => 0,
            'role'          => 1,
            'status'        => 1,
            'password'      => bcrypt('secret'),
        ]);
        $user->assignRole(1);

        return $user;
    }
}
