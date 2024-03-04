<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $fillable = [
        'comment',
        'product_id',
        'commenter_id',
    ];

    use HasFactory;

    public function Commenter() {
        return $this->belongsTo(User::class, 'commenter_id', 'id');
    }

    public function CommentedProduct() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
