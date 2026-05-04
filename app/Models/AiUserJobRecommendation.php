<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiUserJobRecommendation extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
        'match_score',
        'reason_json',
        'model_version',
        'status',
        'error_message',
        'generated_at',
    ];

    protected $casts = [
        'reason_json' => 'array',
        'generated_at' => 'datetime',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function job(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }
}
