<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
