<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryResource;

class StorefrontProductResource extends JsonResource
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
            'price' => $this->price,
            'stock' => $this->stock,
            'is_out_of_stock' => $this->stock == 0,
            'is_close_to_run_out_of_stock' => $this->stock < 10,
            'category' => new CategoryResource($this->category),
            'preview_image' => $this->pictures[0]?->product_picture,
            'ratings' => $this->ratings
        ];
    }
}
