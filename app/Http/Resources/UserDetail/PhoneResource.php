<?php

namespace App\Http\Resources\UserDetail;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneResource extends JsonResource
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
            'number' => $this->number,
            'mask' => $this->mask,
            'formatted_number' => $this->formatNumber($this->number, $this->mask),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_human_readable' => $this->created_at->diffForHumans(),
            'updated_at_human_readable' => $this->updated_at->diffForHumans()
        ];
    }

    private function formatNumber(String $phoneNumber, String $mask) {

        // dd($phoneNumber, $mask);

        $maskParts = explode(' ', $mask);
        [$countryCode, $realMask] = $maskParts;


        for($i = 0; $i< Str::length($phoneNumber); $i++) {
            $j = 0;
            while($j < Str::length($realMask) && $realMask[$j] != '9'){
                $j++;
            }
            $realMask[$j] = $phoneNumber[$i];
        }

        // dd($realMask);
        return "{$countryCode} {$realMask}";
    }
}
