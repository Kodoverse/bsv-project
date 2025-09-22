<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
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
            'reply' => $this->reply,
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
            'comment_id' => $this->comment_id,
            'user' => [
                'id' => $this->user->id,
                'info' => [
                    'username' => $this->user->info ? $this->user->info->username : null,
                    'profile_img' => $this->user->info ? $this->user->info->profile_img : null,
                ],
                'initials' => $this->user->initials,
            ]
        ];
    }
}