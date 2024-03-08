<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'image',
        'product_id'
    ];

    use HasFactory;

    public function Product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
