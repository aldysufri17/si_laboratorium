<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nama', 'info', 'show', 'stock', 'satuan', 'tipe', 'tgl_masuk', 'lokasi', 'rusak', 'gambar'];

    protected $table = 'barang';
}
