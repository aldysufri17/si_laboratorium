<?php

namespace App\Exports;

use App\Models\Inventaris;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MutasiExport implements FromCollection, WithHeadings
{
    private $data;
    private $status;
    public function __construct(int $data, int $status)
    {
        $this->data = $data;
        $this->status = $status;
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
                $name = 'Laboratorium Multimedia';
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
            ['Data Inventaris ' . $name . " Pada " . date('Y-m-d')],
            [
                'Date', 'Kode Mutasi', 'Nama Barang', 'Tipe', 'Masuk', 'Keluar', 'Total', 'Keterangan'
            ]
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

        if ($this->status == 2) {
            $inventaris = Inventaris::join('barang', 'barang.id', '=', 'inventaris.barang_id')
                ->select('inventaris.created_at', 'kode_mutasi', 'barang.nama', 'barang.tipe', 'masuk', 'keluar', 'total', 'deskripsi')
                ->where('inventaris.kategori_lab', $kategori_lab)
                ->where('status', '<', 2)
                ->orderBy('inventaris.created_at', 'DESC')
                ->get();
        } else {
            $inventaris = Inventaris::join('barang', 'barang.id', '=', 'inventaris.barang_id')
                ->select('inventaris.created_at', 'kode_mutasi', 'barang.nama', 'barang.tipe', 'masuk', 'keluar', 'total', 'deskripsi')
                ->where('inventaris.kategori_lab', $kategori_lab)
                ->where('status', $this->status)
                ->orderBy('inventaris.created_at', 'DESC')
                ->get();
        }
        return $inventaris;
    }
}
