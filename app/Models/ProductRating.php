<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    protected $fillable = [
        'rating',
        'product_id'
    ];

    use HasFactory;

    public function Product() {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
}
