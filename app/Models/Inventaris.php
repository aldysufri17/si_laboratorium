<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    protected $table = 'inventaris';
    protected $fillable = ['id', 'barang_id', 'kode_mutasi', 'kategori_lab', 'kode_inventaris', 'masuk', 'keluar', 'total', 'status', 'deskripsi', 'keterangan', 'stok', 'created_at'];
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
