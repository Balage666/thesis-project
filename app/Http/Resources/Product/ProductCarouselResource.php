<?php

namespace App\Http\Resources\Product;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCarouselResource extends JsonResource
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
            'shortened_description' => Str::limit($this->description, 50, '...'),
            'preview_image' => $this->pictures,
            'price' => $this->price,
            'stock' => $this->stock,
        ];
    }
}
