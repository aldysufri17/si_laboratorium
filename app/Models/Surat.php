<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'status'];
    protected $table = 'surat';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
