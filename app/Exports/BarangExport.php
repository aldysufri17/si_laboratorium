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
            ['Kode Barang', 'Kategori', 'Nama', 'Tipe', 'Stok', 'Satuan', 'Lokasi', 'Jenis Jenis Pengadaan']
        ];
    }

    public function collection()
    {
        $barang = Barang::join('satuan', 'satuan.id', '=', 'barang.satuan_id')
            ->join('kategori', 'kategori.id', '=', 'barang.kategori_id')
            ->join('pengadaan', 'pengadaan.id', '=', 'barang.pengadaan_id')
            ->select('kode_barang', 'kategori.nama_kategori', 'barang.nama', 'tipe', 'stock', 'satuan.nama_satuan', 'lokasi', 'pengadaan.nama_pengadaan')
            ->where('barang.laboratorium_id', $this->data)
            ->get();
        return $barang;
    }
}
