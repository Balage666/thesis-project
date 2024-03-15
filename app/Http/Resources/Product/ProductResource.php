<?php

namespace App\Http\Resources\Product;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryResource;

class ProductResource extends JsonResource
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
            'shortened_description' => Str::limit($this->description, 50, '...'),
            'price' => $this->price,
            'stock' => $this->stock,
            'is_out_of_stock' => $this->stock == 0,
            'is_close_to_run_out_of_stock' => $this->stock < 10,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_human_readable' => $this->created_at->diffForHumans(),
            'updated_at_human_readable' => $this->updated_at->diffForHumans(),
            'preview_image' => $this->pictures[0]?->product_picture,
            'category' => new CategoryResource($this->category),
            'distributor' => $this->distributor,
            'comments' => CommentResource::collection($this->comments),
            'ratings' => $this->ratings
        ];
    }
}
