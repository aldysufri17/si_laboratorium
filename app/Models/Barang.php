<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'kategori', 'nama', 'info', 'show', 'stock', 'satuan', 'tipe', 'tgl_masuk', 'lokasi', 'jml_rusak', 'gambar'];

    protected $table = 'barang';
}
