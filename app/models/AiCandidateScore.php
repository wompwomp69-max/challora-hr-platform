<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiCandidateScore extends Model
{
    protected $fillable = [
        'application_id',
        'job_id',
        'user_id',
        'score_total',
        'breakdown_json',
        'reasoning_json',
        'core_strength',
        'confidence',
        'model_version',
        'status',
        'error_message',
        'generated_at',
    ];

    protected $casts = [
        'breakdown_json' => 'array',
        'reasoning_json' => 'array',
        'generated_at' => 'datetime',
        'confidence' => 'float',
    ];

    public function application(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
