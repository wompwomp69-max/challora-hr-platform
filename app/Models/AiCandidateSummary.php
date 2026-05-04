<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiCandidateSummary extends Model
{
    protected $fillable = [
        'application_id',
        'pros_json',
        'cons_json',
        'summary_text',
        'recommendation',
        'model_version',
        'status',
        'error_message',
        'generated_at',
    ];

    protected $casts = [
        'pros_json' => 'array',
        'cons_json' => 'array',
        'generated_at' => 'datetime',
    ];

    public function application(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
