<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stock';
    protected $fillable = ['id', 'barang_id', 'inventaris', 'masuk', 'keluar', 'total', 'status', 'deskripsi', 'created_at'];
}
