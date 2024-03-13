<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'rating',
        'product_id',
        'rater'
    ];

    use HasFactory;

    public function Product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function Rater() {
        return $this->belongsTo(User::class, 'rater', 'id');
    }
}
