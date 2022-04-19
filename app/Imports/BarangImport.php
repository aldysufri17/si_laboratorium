<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Inventaris;
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
            $kategori_lab = 1;
            $lokasi = "Laboratorium Sistem Tertanam dan Robotika";
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
            $lokasi = "Laboratorium Rekayasa Perangkat Lunak";
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
            $lokasi = "Laboratorium Jaringan dan Keamanan Komputer";
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
            $lokasi = "Laboratorium Multimedia";
        }

        $max = Barang::max('id');
        $kode = $max + 1;
        $barang = new Barang([
            'id'            => $kode,
            'nama'          => $row[0],
            'tipe'          => $row[1],
            'stock'         => $row[2],
            'info'          => $row[3],
            'lokasi'        => $lokasi,
            'satuan_id'     => 0,
            'kategori_id'   => 0,
            'show'          => 0,
            'tgl_masuk'     => date('Y-m-d'),
            'kategori_lab'  => $kategori_lab
        ]);

        $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $invetaris = new Inventaris([
            'id'                => substr(str_shuffle("0123456789"), 0, 8),
            'barang_id'         => $kode,
            'status'            => 1,
            'deskripsi'         => 'New',
            'kode_inventaris'   => 'IN' . $random,
            'masuk'             => $row[2],
            'kategori_lab'      => $kategori_lab,
            'keluar'            => 0,
            'total'             => $row[2],
        ]);
        return [$barang, $invetaris];
    }
}
