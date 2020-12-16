<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ID extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_name',
        'id_number',
        'id_image'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
