<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';
    protected $guarded = false;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function thread(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Thread::class, 'thread_id', 'id');
    }

    public function checkUserToEditAnswer(int $answer_id = 0): bool
    {
        $user = auth()->user();

        return (
            $user->role_id === 'admin'
            ||
            $user->id === $this->user->id
            ||
            $user->id === $this->thread->user->id
        );

    }

}
