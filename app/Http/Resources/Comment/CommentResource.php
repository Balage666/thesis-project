<?php

namespace App\Http\Resources\Comment;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment' => $this->comment,
            'shortened_comment' => Str::limit($this->comment, 30, '...'),
            'commenter' => $this->commenter
        ];
    }
}
