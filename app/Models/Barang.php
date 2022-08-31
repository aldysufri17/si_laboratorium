<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'kode_barang', 'satuan_id', 'kategori_id', 'laboratorium_id', 'nama', 'info', 'show', 'stock', 'satuan', 'tipe', 'tgl_masuk', 'lokasi', 'jml_rusak', 'gambar', 'pengadaan_id', 'keterangan_rusak'];

    protected $table = 'barang';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class);
    }
    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }
}
