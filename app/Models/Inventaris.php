<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    protected $table = 'inventaris';
    protected $fillable = ['id', 'barang_id', 'kode_mutasi', 'kode_inventaris', 'masuk', 'keluar', 'total_inventaris', 'status', 'deskripsi', 'keterangan', 'total_mutasi', 'created_at'];
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
