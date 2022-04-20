<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'kode_barang', 'satuan_id', 'kategori_id', 'kategori_lab', 'nama', 'info', 'show', 'stock', 'satuan', 'tipe', 'tgl_masuk', 'lokasi', 'jml_rusak', 'gambar'];

    protected $table = 'barang';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
