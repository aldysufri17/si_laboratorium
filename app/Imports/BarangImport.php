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
            $kbrg = 'EM-';
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
            $lokasi = "Laboratorium Rekayasa Perangkat Lunak";
            $kbrg = 'RL-';
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
            $lokasi = "Laboratorium Jaringan dan Keamanan Komputer";
            $kbrg = 'JK-';
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
            $lokasi = "Laboratorium Multimedia";
            $kbrg = 'MD-';
        }

        $max = Barang::max('id');
        $kode = $max + 1;
        if (strlen($kode) == 1) {
            $kode_barang = "000" . $kode;
        } else if (strlen($kode) == 2) {
            $kode_barang = "00" . $kode;
        } else if (strlen($kode) == 3) {
            $kode_barang = "0" . $kode;
        } else {
            $kode_barang = $kode;
        }

        if ($row[3] == null) {
            $info = '-';
        } else {
            $info = $row[3];
        }



        $barang = new Barang([
            'id'            => $kode,
            'kode_barang'   => $kbrg . $kode_barang,
            'nama'          => $row[0],
            'tipe'          => $row[1],
            'stock'         => $row[2],
            'info'          => $info,
            'lokasi'        => $lokasi,
            'satuan_id'     => 0,
            'pengadaan_id'  => 1,
            'kategori_id'   => 0,
            'show'          => 0,
            'tgl_masuk'     => date('Y-m-d'),
            'kategori_lab'  => $kategori_lab
        ]);
        $Date = date("Y/m/d");
        $year = date('Y', strtotime($Date));
        $random = date('dmY') . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        $invetaris = new Inventaris([
            'barang_id'         => $kode,
            'status'            => 1,
            'deskripsi'         => 'Created',
            'kode_mutasi'       => 'IN' . $random,
            'kode_inventaris'   => $kode . '.' . $random . '.' . $year,
            'masuk'             => $row[2],
            'kategori_lab'      => $kategori_lab,
            'keluar'            => 0,
            'total_inventaris'  => $row[2],
            'total_mutasi'       => 0,
        ]);

        $mutasi = new Inventaris([
            'barang_id'         => $kode,
            'status'            => 1,
            'deskripsi'         => 'Baru',
            'kode_mutasi'       => 'IN' . $random,
            'kode_inventaris'   => 'IN' . $random,
            'masuk'             => $row[2],
            'kategori_lab'      => $kategori_lab,
            'keluar'            => 0,
            'total_inventaris'  => 0,
            'total_mutasi'      => $row[2],
        ]);
        return [$barang, $invetaris, $mutasi];
    }
}
