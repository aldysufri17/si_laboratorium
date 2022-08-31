<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DamagedExport implements FromCollection, WithHeadings
{
    private $data;
    private $name;
    public function __construct(int $data, $name)
    {
        $this->data = $data;
        $this->name = $name;
    }

    public function headings(): array
    {
        return [
            ['Data Barang ' . $this->name . " Pada " . date('Y-m-d')],
            ['Waktu', 'Kode Barang', 'Kategori', 'Jenis Pengadaan', 'Nama', 'Tipe', 'Jumlah Rusak', 'Keterangan']
        ];
    }

    public function collection()
    {
        $barang = Barang::join('kategori', 'kategori.id', '=', 'barang.kategori_id')
            ->join('pengadaan', 'pengadaan.id', '=', 'barang.pengadaan_id')
            ->select('barang.updated_at', 'kode_barang', 'kategori.nama_kategori', 'pengadaan.nama_pengadaan', 'nama', 'tipe', 'jml_rusak', 'keterangan_rusak')
            ->whereNotNull('jml_rusak')
            ->where('barang.laboratorium_id', $this->data)
            ->get();
        return $barang;
    }
}
