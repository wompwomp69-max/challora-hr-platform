<?php

namespace App\Services\Hr;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class IntelligenceService
{
    public function getDashboardData(int $hrId): array
    {
        return cache()->remember("hr_dashboard_{$hrId}", now()->addMinutes(2), function () use ($hrId) {
            return $this->buildDashboardData($hrId);
        });
    }

    private function buildDashboardData(int $hrId): array
    {
        $jobs = JobPosting::query()
            ->where('created_by', $hrId)
            ->select(['id', 'title', 'location'])
            ->orderByDesc('created_at')
            ->get();

        if ($jobs->isEmpty()) {
            return [
                'topCandidatesByJob' => collect(),
                'availableCompatibleCandidates' => collect(),
                'selectedCandidateDetail' => null,
                'defaultSelectedApplicationId' => null,
            ];
        }

        $applications = Application::query()
            ->whereIn('job_id', $jobs->pluck('id'))
            ->whereHas('aiScore', fn (Builder $q) => $q->where('status', 'completed'))
            ->with([
                'job:id,title,skills_json,experience_level,created_by',
                'user:id,name,email,address,user_summary',
                'aiScore:application_id,score_total,confidence,status',
                'aiSummary:application_id,pros_json,cons_json,summary_text,recommendation,status',
            ])
            ->orderByDesc(
                \App\Models\AiCandidateScore::select('score_total')
                    ->whereColumn('ai_candidate_scores.application_id', 'applications.id')
                    ->limit(1)
            )
            ->get();

        $topCandidatesByJob = $jobs->map(function (JobPosting $job) use ($applications) {
            $candidates = $applications
                ->where('job_id', $job->id)
                ->sortByDesc(fn (Application $application) => $application->aiScore?->score_total ?? 0)
                ->take(5)
                ->map(fn (Application $application) => $this->formatCandidateCard($application))
                ->values();

            return [
                'job' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'location' => $job->location ?: 'Remote',
                ],
                'candidates' => $candidates,
            ];
        })->filter(fn (array $item) => collect($item['candidates'])->isNotEmpty())->values();

        $availableCompatibleCandidates = $applications
            ->filter(fn (Application $application) => ($application->aiScore?->score_total ?? 0) >= 60)
            ->map(fn (Application $application) => $this->formatCandidateCard($application))
            ->values();

        $defaultApplication = $availableCompatibleCandidates->first()['application_id'] ?? $applications->first()?->id;
        $selectedCandidateDetail = $defaultApplication
            ? $this->getCandidateDetailByApplication($hrId, (int) $defaultApplication)
            : null;

        return [
            'topCandidatesByJob' => $topCandidatesByJob,
            'availableCompatibleCandidates' => $availableCompatibleCandidates,
            'selectedCandidateDetail' => $selectedCandidateDetail,
            'defaultSelectedApplicationId' => $defaultApplication,
        ];
    }

    public function getCandidateDetailByApplication(int $hrId, int $applicationId): ?array
    {
        $application = Application::query()
            ->whereKey($applicationId)
            ->whereHas('job', fn (Builder $q) => $q->where('created_by', $hrId))
            ->with([
                'job:id,title,skills_json,experience_level,created_by',
                'user',
                'user.workExperiences',
                'user.achievements',
                'user.organizationalExperiences',
                'aiScore:application_id,score_total,confidence,status',
                'aiSummary:application_id,pros_json,cons_json,summary_text,recommendation,status',
            ])
            ->first();

        if (!$application) {
            return null;
        }

        $jobSkills = collect($application->job?->skills_json ?? [])->filter()->values();

        return [
            'application_id' => $application->id,
            'job' => [
                'id' => $application->job?->id,
                'title' => $application->job?->title,
                'required_skills' => $jobSkills,
            ],
            'candidate' => [
                'id' => $application->user?->id,
                'name' => $application->user?->name,
                'email' => $application->user?->email,
                'address' => $application->user?->address ?: 'Unknown',
                'phone' => $application->user?->phone,
                'gender' => $application->user?->gender,
                'birth_place' => $application->user?->birth_place,
                'birth_date' => $application->user?->birth_date?->format('d M Y'),
                'marital_status' => $application->user?->marital_status,
                'religion' => $application->user?->religion,
                'education_level' => $application->user?->education_level,
                'education_university' => $application->user?->education_university,
                'education_major' => $application->user?->education_major,
                'graduation_year' => $application->user?->graduation_year,
                'user_summary' => $application->user?->user_summary,
                'experiences' => $application->user?->workExperiences,
                'achievements' => $application->user?->achievements,
                'org_experiences' => $application->user?->organizationalExperiences,
                'family' => [
                    'father_name' => $application->user?->father_name,
                    'mother_name' => $application->user?->mother_name,
                    'father_job' => $application->user?->father_job,
                    'mother_job' => $application->user?->mother_job,
                ],
                'emergency' => [
                    'name' => $application->user?->emergency_name,
                    'phone' => $application->user?->emergency_phone,
                ],
                'cv_path' => $application->cv_path,
                'diploma_path' => $application->diploma_path,
                'photo_path' => $application->photo_path,
            ],
            'ai' => [
                'score_total' => $application->aiScore?->score_total ?? 0,
                'confidence' => $application->aiScore?->confidence ?? 0,
                'pros' => $this->toStringList($application->aiSummary?->pros_json),
                'cons' => $this->toStringList($application->aiSummary?->cons_json),
                'summary_text' => $application->aiSummary?->summary_text,
                'recommendation' => $application->aiSummary?->recommendation,
            ],
            'compatibility' => [
                'match_ratio' => null,
            ],
        ];
    }

    protected function formatCandidateCard(Application $application): array
    {
        return [
            'application_id' => $application->id,
            'job_id' => $application->job_id,
            'job_title' => $application->job?->title,
            'candidate_name' => $application->user?->name,
            'candidate_region' => $application->user?->address ?: 'Unknown',
            'score_total' => $application->aiScore?->score_total ?? 0,
        ];
    }

    protected function toStringList(mixed $items): Collection
    {
        if (!is_array($items)) {
            return collect();
        }

        return collect($items)
            ->map(fn ($item) => is_string($item) ? $item : null)
            ->filter()
            ->values();
    }
}
