<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'barang_id', 'jumlah', 'keperluan', 'tgl_start', 'tgl_end', 'status', 'date'];
    protected $table = 'peminjaman';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
