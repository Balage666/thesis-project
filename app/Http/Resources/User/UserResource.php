<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Http\Resources\UserDetail\PhoneResource;
use App\Http\Resources\UserDetail\AddressResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'email_verified_at_human_readable' => $this->email_verified_at?->diffForHumans(),
            'google_id' => $this->google_id,
            'signed_in_with_google' => $this->google_id != null,
            'profile_picture' => $this->profile_picture,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_human_readable' => $this->created_at->diffForHumans(),
            'updated_at_human_readable' => $this->updated_at->diffForHumans(),
            'roles' => $this->roles,
            'has_seller_role' => $this->roles()->where('name', 'Seller')->exists(),
            'phone_numbers' => PhoneResource::collection($this->phoneNumbers),
            'addresses' => AddressResource::collection($this->addresses),
            'products' => ProductResource::collection($this->products),
            'favorites' => $this->favorites,
        ];
    }
}
