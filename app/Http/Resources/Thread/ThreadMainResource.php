<?php

namespace App\Http\Resources\Thread;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadMainResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $this->user->id,
            'theme_id' => $this->theme->id,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
