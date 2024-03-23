<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'full_name',
        'email',
        'address_text',
        'state_or_region',
        'postal_or_zip_code',
        'country',
        'phone_number'
    ];

    public function Customer() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function OrderItems() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
