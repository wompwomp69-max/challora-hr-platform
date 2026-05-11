<?php

namespace App\Jobs\Ai;

use App\Models\AiCandidateScore;
use App\Models\Application;
use App\Services\Ai\AiGatewayService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateCvRatingJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public function __construct(public int $applicationId)
    {
    }

    public function handle(AiGatewayService $aiGateway): void
    {
        $application = Application::with([
            'job',
            'user.workExperiences',
            'user.achievements',
            'user.organizationalExperiences',
        ])->find($this->applicationId);
        if (!$application) {
            return;
        }

        $score = AiCandidateScore::firstOrNew(['application_id' => $application->id]);
        $score->fill([
            'job_id' => $application->job_id,
            'user_id' => $application->user_id,
            'status' => 'processing',
        ])->save();

        $response = $aiGateway->rateCv([
            'job_description'  => $application->job?->description ?? '',
            'candidate_name'   => $application->user?->name ?? 'Candidate',
            'candidate_profile' => [
                // Job context — sent inside profile so the AI has full picture in one block
                'job_title'              => $application->job?->title,
                'job_required_skills'    => $application->job?->skills_json ?? [],
                'job_experience_level'   => $application->job?->experience_level?->value ?? '',
                'job_min_education'      => $application->job?->min_education?->value ?? '',

                // Candidate data
                'summary'    => $application->user?->user_summary,
                'education'  => [
                    'level'           => $application->user?->education_level,
                    'major'           => $application->user?->education_major,
                    'university'      => $application->user?->education_university,
                    'graduation_year' => $application->user?->graduation_year,
                ],
                'work_experiences' => $application->user?->workExperiences?->map(fn ($exp) => [
                    'title'        => $exp->title,
                    'company_name' => $exp->company_name,
                    'year_start'   => $exp->year_start,
                    'year_end'     => $exp->year_end,
                    'description'  => $exp->description,
                ])->toArray() ?? [],
                'organizational_experiences' => $application->user?->organizationalExperiences?->map(fn ($org) => [
                    'organization' => $org->organization_name,
                    'position'     => $org->position,
                    'year_start'   => $org->start_year,
                    'year_end'     => $org->year_end,
                    'description'  => $org->description,
                ])->toArray() ?? [],
                'achievements' => $application->user?->achievements?->map(fn ($a) => [
                    'title'       => $a->title,
                    'type'        => $a->type,
                    'organizer'   => $a->organizer,
                    'year'        => $a->year,
                    'rank'        => $a->rank,
                    'level'       => $a->level,
                    'description' => $a->description,
                ])->toArray() ?? [],
            ],
        ]);

        if (!$response['ok']) {
            $score->update([
                'status' => 'failed',
                'error_message' => $response['error'],
            ]);
            return;
        }

        $data = $response['data'];
        $score->update([
            'score_total'    => (int) ($data['score_total'] ?? 0),
            'breakdown_json' => $data['score_breakdown'] ?? [],
            'reasoning_json' => $data['technical_reasoning'] ?? [],
            'core_strength'  => $data['core_strength'] ?? null,
            'confidence'     => (float) ($data['confidence'] ?? 0),
            'model_version'  => config('ai.model_version'),
            'status'         => 'completed',
            'error_message'  => null,
            'generated_at'   => now(),
        ]);

        // Bust HR intelligence dashboard cache so fresh scores appear immediately
        cache()->forget("hr_dashboard_" . $application->job?->created_by);
    }
}
