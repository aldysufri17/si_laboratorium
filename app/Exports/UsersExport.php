<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return ['NIM', 'Nama', 'Email', 'Alamat', 'Jenis Kelamin', 'No Telp'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = DB::table('users')
            ->select('nim', 'name', 'email', 'alamat', 'jk', 'mobile_number',)
            ->where('role_id', 1)
            ->get();
        return $user;
    }
}
