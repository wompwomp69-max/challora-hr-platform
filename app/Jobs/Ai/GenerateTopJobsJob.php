<?php

namespace App\Jobs\Ai;

use App\Models\AiUserJobRecommendation;
use App\Models\JobPosting;
use App\Models\User;
use App\Services\Ai\AiGatewayService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateTopJobsJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public function __construct(public int $userId)
    {
    }

    public function handle(AiGatewayService $aiGateway): void
    {
        $user = User::with(['workExperiences', 'achievements'])->find($this->userId);
        if (!$user) {
            return;
        }

        $jobs = JobPosting::query()->latest()->take(30)->get(['id', 'title', 'description', 'location', 'job_type', 'experience_level', 'min_education']);
        if ($jobs->isEmpty()) {
            return;
        }

        $response = $aiGateway->recommendJobs([
            'user_profile' => [
                'name' => $user->name,
                'summary' => $user->user_summary,
                'skills' => $user->skills,
                'education_level' => $user->education_level,
                'education_major' => $user->education_major,
                'work_experiences' => $user->workExperiences->map(fn ($exp) => [
                    'title' => $exp->title,
                    'company_name' => $exp->company_name,
                    'description' => $exp->description,
                ])->toArray(),
            ],
            'jobs' => $jobs->map(fn ($job) => [
                'job_id' => $job->id,
                'title' => $job->title,
                'description' => $job->description,
                'location' => $job->location,
                'job_type' => $job->job_type?->value ?? $job->job_type,
                'experience_level' => $job->experience_level?->value ?? $job->experience_level,
                'min_education' => $job->min_education?->value ?? $job->min_education,
            ])->toArray(),
        ]);

        if (!$response['ok']) {
            return;
        }

        foreach ($response['data'] as $recommendation) {
            if (empty($recommendation['job_id'])) {
                continue;
            }

            AiUserJobRecommendation::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'job_id' => (int) $recommendation['job_id'],
                ],
                [
                    'match_score' => (int) ($recommendation['match_score'] ?? 0),
                    'reason_json' => is_array($recommendation['reasoning'] ?? null)
                        ? $recommendation['reasoning']
                        : [$recommendation['reasoning'] ?? ''],
                    'model_version' => config('ai.model_version'),
                    'status' => 'completed',
                    'error_message' => null,
                    'generated_at' => now(),
                ]
            );
        }
    }
}
