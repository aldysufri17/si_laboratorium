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
    private $data;
    public function __construct(int $data)
    {
        $this->data = $data;
    }
    public function headings(): array
    {
        if (Auth::user()->role_id == 2) {
            if ($this->data == 1) {
                $name = 'Laboratorium Sistem Tertanam dan Robotika';
            } elseif ($this->data == 2) {
                $name = 'Laboratorium Rekayasa Perangkat Lunak';
            } elseif ($this->data == 3) {
                $name = 'Laboratorium Jaringan dan Keamanan Komputer';
            } elseif ($this->data == 4) {
                $kategori_lab = 4;
            }
        }

        if (Auth::user()->role_id == 3) {
            $name = 'Laboratorium Sistem Tertanam dan Robotika';
        } elseif (Auth::user()->role_id == 4) {
            $name = 'Laboratorium Rekayasa Perangkat Lunak';
        } elseif (Auth::user()->role_id == 5) {
            $name = 'Laboratorium Jaringan dan Keamanan Komputer';
        } elseif (Auth::user()->role_id == 6) {
            $name = 'Laboratorium Multimedia';
        }
        return [
            ['Data Peminjaman ' . $name . " Pada " . date('Y-m-d')],
            ['Date', 'NIM', 'Nama', 'Barang', 'Tipe', 'Jumlah', 'Tanggal Peminjaman', 'Tanggal Pengembalian', 'Alasan']
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (Auth::user()->role_id == 2) {
            if ($this->data == 1) {
                $kategori_lab = 1;
            } elseif ($this->data == 2) {
                $kategori_lab = 2;
            } elseif ($this->data == 3) {
                $kategori_lab = 3;
            } elseif ($this->data == 4) {
                $kategori_lab = 4;
            }
        }

        if (Auth::user()->role_id == 3) {
            $kategori_lab = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
        }

        $peminjaman = Peminjaman::join('barang', 'barang.id', '=', 'peminjaman.barang_id')
            ->join('users', 'users.id', '=', 'peminjaman.user_id')
            ->select('peminjaman.created_at', 'users.nim', 'users.name', 'barang.nama', 'barang.tipe', 'jumlah', 'tgl_start', 'tgl_end', 'alasan',)
            ->where('peminjaman.status', 4)
            ->where('peminjaman.kategori_lab', $kategori_lab)
            ->get();
        return $peminjaman;
    }
}
