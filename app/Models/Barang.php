<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nama', 'show', 'berat', 'tipe', 'tgl_masuk', 'lokasi', 'kondisi', 'gambar'];

    protected $table = 'barang';
}
