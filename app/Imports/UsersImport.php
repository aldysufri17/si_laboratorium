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
        return new User([
            'nim'           => $row[0],
            'name'          => $row[1],
            'email'         => $row[2],
            'alamat'        => $row[3],
            'jk'            => $row[4],
            'mobile_number' => $row[5],
            'role_id'       => 1,
            'status'        => 1,
            'password'      => bcrypt('12345678'),
        ]);
    }
}
