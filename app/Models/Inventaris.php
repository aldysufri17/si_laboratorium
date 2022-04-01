<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    protected $table = 'inventaris';
    protected $fillable = ['id', 'barang_id', 'kategori', 'kode_inventaris', 'masuk', 'keluar', 'total', 'status', 'deskripsi', 'created_at'];
}
