<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'alamat_lengkap',
        'latitude',
        'longitude',
        'ongkir_per_km',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
