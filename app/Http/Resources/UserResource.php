<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'google_id' => $this->google_id,
            'profile_picture' => $this->profile_picture,
            'created_at' => $this->created_at,
            'roles' => $this->roles,
            'addresses' => $this->addresses,
            'products' => $this->products
            // 'checked' => false
        ];
    }
}
