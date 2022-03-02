<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBarang extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'barang_id', 'jumlah', 'keperluan', 'tgl_start', 'tgl_end', 'status'];
    protected $table = 'peminjaman_barang';
}
