<?php

namespace App\Http\Resources\Answer;

use App\Http\Resources\User\UserMainResource;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerMainResource extends JsonResource
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
            'content' => $this->content,
            'user' => (new UserMainResource($this->user))->resolve(),
            'created_at' => $this->created_at->diffForHumans(),
            'childAnswers' => $this->childAnswers(),
            'answer_to' => $this->answer_to
        ];
    }
}
