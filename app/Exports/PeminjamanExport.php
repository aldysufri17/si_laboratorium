<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PeminjamanExport implements FromCollection, WithHeadings
{
    private $data, $name;
    public function __construct(int $data, $name)
    {
        $this->data = $data;
        $this->name = $name;
    }
    public function headings(): array
    {
        if ($this->data == 0) {
            return [
                ['Data Peminjaman Admin Pada' . date('Y-m-d')],
                ['Date', 'Kode Peminjaman', 'NIM', 'Nama', 'Barang', 'Tipe', 'Jumlah', 'Tanggal Peminjaman', 'Tanggal Pengembalian', 'Alasan']
            ];
        } else {
            return [
                ['Data Peminjaman ' . $this->name . " Pada " . date('Y-m-d')],
                ['Date', 'Kode Peminjaman', 'NIM', 'Nama', 'Barang', 'Tipe', 'Jumlah', 'Tanggal Peminjaman', 'Tanggal Pengembalian', 'Alasan']
            ];
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->data == 0) {
            $peminjaman = Peminjaman::join('barang', 'barang.id', '=', 'peminjaman.barang_id')
                ->join('users', 'users.id', '=', 'peminjaman.user_id')
                ->select('peminjaman.created_at', 'kode_peminjaman', 'users.nim', 'users.name', 'barang.nama', 'barang.tipe', 'jumlah', 'tgl_start', 'tgl_end', 'alasan')
                ->where('peminjaman.status', 4)
                ->get();
        } else {
            $peminjaman = Peminjaman::join('barang', 'barang.id', '=', 'peminjaman.barang_id')
                ->join('users', 'users.id', '=', 'peminjaman.user_id')
                ->select('peminjaman.created_at', 'kode_peminjaman', 'users.nim', 'users.name', 'barang.nama', 'barang.tipe', 'jumlah', 'tgl_start', 'tgl_end', 'alasan')
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->data);
                })
                ->where('peminjaman.status', 4)
                ->get();
        }
        return $peminjaman;
    }
}
