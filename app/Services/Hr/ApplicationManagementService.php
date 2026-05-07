<?php

namespace App\Services\Hr;

use App\Mail\ApplicationStatusMail;
use App\Models\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

class ApplicationManagementService
{
    public function getApplications(int $hrId, ?string $status, ?int $jobId, ?string $sortRating = null): LengthAwarePaginator
    {
        $query = Application::whereHas('job', function($q) use ($hrId) {
            $q->where('created_by', $hrId);
        })->with(['job', 'user', 'aiScore']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($jobId) {
            $query->where('job_id', $jobId);
        }

        if ($sortRating === 'high') {
            $query->join('ai_candidate_scores', 'applications.id', '=', 'ai_candidate_scores.application_id')
                ->orderBy('ai_candidate_scores.score_total', 'desc')
                ->select('applications.*');
        } elseif ($sortRating === 'low') {
            $query->join('ai_candidate_scores', 'applications.id', '=', 'ai_candidate_scores.application_id')
                ->orderBy('ai_candidate_scores.score_total', 'asc')
                ->select('applications.*');
        } else {
            $query->latest();
        }

        return $query->paginate(10);
    }

    public function updateStatus(Application $application, string $status): bool
    {
        $updated = $application->update(['status' => $status]);

        if ($updated) {
            $application->load(['user', 'job']);
            try {
                Mail::to($application->user->email)->send(new ApplicationStatusMail($application));
            } catch (\Exception $e) {
                \Log::warning('Failed to send status email: ' . $e->getMessage());
            }
        }

        return $updated;
    }
}
