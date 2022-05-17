<?php

namespace App\Exports;

use App\Models\Surat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SuratExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            ['Data Riwayat Surat Pada' . date('Y-m-d')],
            ['kode', 'Nama', 'NIM', 'Alamat', 'Waktu Pembuatan']
        ];
    }

    public function collection()
    {
        $surat = Surat::select('kode', 'nama', 'nim', 'alamat', 'created_at')
            ->where('status', 2)
            ->get();
        return $surat;
    }
}
