<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiUserProfileSuggestion extends Model
{
    protected $fillable = [
        'user_id',
        'target_role',
        'suggestion_json',
        'model_version',
        'status',
        'error_message',
        'generated_at',
    ];

    protected $casts = [
        'suggestion_json' => 'array',
        'generated_at' => 'datetime',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
