<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
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
            ['Data Barang ' . $name . " Pada " . date('Y-m-d')],
            ['Kategori', 'Nama', 'Tipe', 'Stok', 'Satuan', 'Lokasi', 'Keterangan']
        ];
    }

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
        $barang = Barang::join('satuan', 'satuan.id', '=', 'barang.satuan_id')
            ->join('kategori', 'kategori.id', '=', 'barang.kategori_id')
            ->select('kategori.nama_kategori', 'barang.nama', 'tipe', 'stock', 'satuan.nama_satuan', 'lokasi', 'info')
            ->where('barang.kategori_lab', $kategori_lab)
            ->get();
        return $barang;
    }
}
