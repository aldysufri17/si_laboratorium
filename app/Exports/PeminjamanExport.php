<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PeminjamanExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return ['Date', 'NIM', 'Nama', 'Barang', 'Tipe', 'Jumlah', 'Satuan', 'Tanggal Peminjaman', 'Tanggal Pengembalian', 'Alasan'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $peminjaman = Peminjaman::join('barang', 'barang.id', '=', 'peminjaman.barang_id')
            ->join('users', 'users.id', '=', 'peminjaman.user_id')
            ->select('peminjaman.created_at', 'users.nim', 'users.name', 'barang.nama', 'barang.tipe', 'jumlah', 'barang.satuan', 'tgl_start', 'tgl_end', 'alasan',)
            ->where('peminjaman.status', 4)
            ->get();
        return $peminjaman;
    }
}
