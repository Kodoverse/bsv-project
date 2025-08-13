<?php

namespace App\Http\Resources;

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
        $flagCount = $this->flags->count();

        if($flagCount >= 3){
            return [
                'id' => $this->id,
                'status' => 'hidden',
                'message' => 'Commento nascosto per segnalazioni.',
            ];
        }
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'like' => $this->like,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                'id' => $this->user->id,
                'info' => [
                    'username' => $this->user->info ? $this->user->info->username : null,
                ],
                'initials' => $this->user->initials,
            ],
            'flags' => $this->flags,
        ];
    }
}
