<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    protected $fillable = [
        'image',
        'product_id'
    ];

    use HasFactory;

    public function Product() {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
}
