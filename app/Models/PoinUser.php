<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_poin',
    ];

    public function histories()
    {
        return $this->hasMany(PoinHistory::class, 'user_id', 'user_id');
    }
}
