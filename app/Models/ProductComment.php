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
        return $this->belongsTo(User::class, 'id', 'commenter_id');
    }

    public function CommentedProduct() {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
}
