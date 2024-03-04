<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'created_by',
        'category_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    use HasFactory;

    public function Distributor() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function Category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function Pictures() {
        return $this->hasMany(ProductPicture::class, 'product_id', 'id');
    }

    public function Comments() {
        return $this->hasMany(ProductComment::class, 'product_id', 'id');
    }

    public function Ratings() {
        return $this->hasMany(ProductRating::class, 'product_id', 'id');
    }
}
