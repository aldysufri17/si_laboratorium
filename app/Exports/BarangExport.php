<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class BarangExport implements FromCollection, WithHeadings, WithCustomCsvSettings
{
    private $data;
    public function __construct(int $data)
    {
        $this->data = $data;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Tipe', 'Stok', 'Satuan', 'Lokasi', 'Keterangan'];
    }

    public function collection()
    {
        if (Auth::user()->role_id == 2) {
            if ($this->data == 1) {
                $kategori = 1;
            } elseif ($this->data == 2) {
                $kategori = 2;
            } elseif ($this->data == 3) {
                $kategori = 3;
            } elseif ($this->data == 4) {
                $kategori = 4;
            }
        }

        if (Auth::user()->role_id == 3) {
            $kategori = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori = 4;
        }
        $barang = DB::table('barang')
            ->where('kategori', $kategori)
            ->select('nama', 'tipe', 'stock', 'satuan', 'lokasi', 'info')
            ->get();
        return $barang;
    }
}
