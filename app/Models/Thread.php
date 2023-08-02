<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $table = 'threads';
    protected $guarded = false;

    public function theme(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'thread_id', 'id');
    }
}
