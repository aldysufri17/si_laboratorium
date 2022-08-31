<?php

namespace App\Exports;

use App\Models\Inventaris;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class InventarisExport implements FromCollection, WithHeadings
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
            ['Data Inventaris ' . $this->name . " Pada " . date('Y-m-d')],
            [
                'Date', 'Kode_inventaris', 'Nama Barang', 'Tipe', 'Baik', 'Rusak', 'Keterangan'
            ]
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $inventaris = Inventaris::join('barang', 'barang.id', '=', 'inventaris.barang_id')
            ->select('kode_inventaris', 'kode_barang', 'barang.nama', 'barang.tipe', 'barang.stock', 'barang.jml_rusak', 'inventaris.keterangan')
            ->where('barang.laboratorium_id', $this->data)
            ->where('status', 2)
            ->orderBy('inventaris.created_at', 'DESC')
            ->get();
        return $inventaris;
    }
}
