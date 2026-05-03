<?php

namespace App\Jobs\Ai;

use App\Models\AiUserProfileSuggestion;
use App\Models\User;
use App\Services\Ai\AiGatewayService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateProfileSuggestionJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public function __construct(public int $userId, public ?string $targetRole = null)
    {
    }

    public function handle(AiGatewayService $aiGateway): void
    {
        $user = User::with(['workExperiences', 'achievements'])->find($this->userId);
        if (!$user) {
            return;
        }

        $record = AiUserProfileSuggestion::create([
            'user_id' => $user->id,
            'target_role' => $this->targetRole,
            'status' => 'processing',
        ]);

        $response = $aiGateway->suggestProfile([
            'target_role' => $this->targetRole,
            'profile' => [
                'name' => $user->name,
                'summary' => $user->user_summary,
                'education_level' => $user->education_level,
                'education_major' => $user->education_major,
                'education_university' => $user->education_university,
                'work_experiences' => $user->workExperiences->map(fn ($exp) => [
                    'title' => $exp->title,
                    'company_name' => $exp->company_name,
                    'description' => $exp->description,
                ])->toArray(),
                'achievements' => $user->achievements->map(fn ($item) => [
                    'title' => $item->title,
                    'description' => $item->description,
                ])->toArray(),
            ],
        ]);

        if (!$response['ok']) {
            $record->update([
                'status' => 'failed',
                'error_message' => $response['error'],
            ]);
            return;
        }

        $record->update([
            'suggestion_json' => $response['data'],
            'model_version' => config('ai.model_version'),
            'status' => 'completed',
            'error_message' => null,
            'generated_at' => now(),
        ]);
    }
}
