<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id'
    ];
    use HasFactory;

    public function User() {
        $this->belongsTo(User::class, 'id', 'user_id');
    }
}
