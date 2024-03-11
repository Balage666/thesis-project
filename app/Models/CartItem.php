<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'product_id',
        'amount',
        'price'
    ];

    public function Cart() {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function ProductItem() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
