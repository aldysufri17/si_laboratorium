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
    private $name;
    public function __construct(int $data, int $status, $name)
    {
        $this->data = $data;
        $this->status = $status;
        $this->name = $name;
    }

    public function headings(): array
    {
        return [
            ['Data Inventaris ' . $this->name . " Pada " . date('Y-m-d')],
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

        if ($this->status == 2) {
            $inventaris = Inventaris::join('barang', 'barang.id', '=', 'inventaris.barang_id')
                ->select('inventaris.created_at', 'kode_mutasi', 'barang.nama', 'barang.tipe', 'masuk', 'keluar', 'total_mutasi', 'deskripsi')
                ->where('barang.laboratorium_id', $this->data)
                ->where('status', '<', 2)
                ->orderBy('inventaris.created_at', 'DESC')
                ->get();
        } else {
            $inventaris = Inventaris::join('barang', 'barang.id', '=', 'inventaris.barang_id')
                ->select('inventaris.created_at', 'kode_mutasi', 'barang.nama', 'barang.tipe', 'masuk', 'keluar', 'total_mutasi', 'deskripsi')
                ->where('barang.laboratorium_id', $this->data)
                ->where('status', $this->status)
                ->orderBy('inventaris.created_at', 'DESC')
                ->get();
        }
        return $inventaris;
    }
}
