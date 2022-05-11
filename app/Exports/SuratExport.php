<?php

namespace App\Exports;

use App\Models\Surat;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuratExport implements FromCollection
{
    public function headings(): array
    {
        return [
            ['Data Riwayat Surat Pada' . date('Y-m-d')],
            ['Nama', 'NIM', 'Alamat', 'Tanggal']
        ];
    }

    public function collection()
    {
        $surat = Surat::join('user', 'user.id', '=', 'surat.user_id')
            ->select('user.name', 'user.nim', 'user.alamat', 'surat.created_at')
            ->where('status', 1)
            ->get();
        return $surat;
    }
}
