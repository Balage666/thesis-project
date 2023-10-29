<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'address',
        'user_id'
    ];
    use HasFactory;

    public function User() {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
