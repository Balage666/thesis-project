<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function Customer() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function CartItems() {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }
}
