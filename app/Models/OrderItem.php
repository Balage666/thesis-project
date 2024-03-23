<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'amount',
        'price'
    ];

    public function Order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function OrderedProduct() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
