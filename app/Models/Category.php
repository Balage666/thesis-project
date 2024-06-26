<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function Products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function User() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
