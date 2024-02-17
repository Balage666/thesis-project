<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'number',
        'user_id'
    ];
    use HasFactory;

    public function User() {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
