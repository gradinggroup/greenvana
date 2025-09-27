<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jumlah',
        'jenis',
        'keterangan',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
