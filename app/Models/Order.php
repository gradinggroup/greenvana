<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [
        'longitude', 
        'latitude',
        'alamat_lengkap',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id','id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id','id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id','id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id','id');
    }

    public function order_items()
{
    return $this->hasMany(OrderItem::class, 'order_id', 'id');
}

    
}
