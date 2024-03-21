<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'preview_image' => $this->pictures->first()?->product_picture,
            'images' => $this->pictures,
            'price' => "€ $this->price",
            'stock' => $this->stock,
            'distributor' => $this->distributor,
            'category_id' => $this->category->id,
            'comments' => CommentResource::collection($this->comments),
            'ratings' => $this->ratings,
            'count_of_ratings' => $this->ratings->count(),
            'sum_of_ratings' => $this->ratings->sum('rating'),
            'avg_of_ratings' => $this->ratings->avg('rating')
        ];
    }
}
