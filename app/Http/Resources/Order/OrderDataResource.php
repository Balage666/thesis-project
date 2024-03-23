<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDataResource extends JsonResource
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
            'customer' => $this->customer,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'status' => $this->status,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'address_text' => $this->address_text,
            'state_or_region' => $this->state_or_region,
            'postal_or_zip_code' => $this->postal_or_zip_code,
            'country' => $this->country,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_human_readable' => $this->created_at->diffForHumans(),
            'updated_at_human_readable' => $this->updated_at->diffForHumans(),
        ];
    }
}
