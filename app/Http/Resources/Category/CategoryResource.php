<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ProductCarouselResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // dd($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_human_readable' => $this->created_at->diffForHumans(),
            'updated_at_human_readable' => $this->updated_at->diffForHumans(),
            'products' => ProductCarouselResource::collection($this->Products),
            'user' => $this->User
        ];
    }
}
