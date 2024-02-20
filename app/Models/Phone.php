<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    protected $fillable = [
        'countryIso2code',
        'number',
        'mask',
        'user_id',
    ];
    use HasFactory;

    public function User() {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
