<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class BarangImport implements ToModel, WithStartRow, WithCustomCsvSettings
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (Auth::user()->role_id == 3) {
            $kategori = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori = 4;
        }
        return new Barang([
            'nama'      => $row[0],
            'tipe'      => $row[1],
            'stock'     => $row[2],
            'satuan'    => $row[3],
            'lokasi'    => $row[4],
            'info'      => $row[5],
            'show'      => 1,
            'tgl_masuk' => date('Y-m-d'),
            'kategori'  => $kategori
        ]);
    }
}
