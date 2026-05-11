<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Jobs\Ai\GenerateCandidateSummaryJob;
use App\Jobs\Ai\GenerateCvRatingJob;
use App\Models\Application;
use App\Services\Hr\ApplicationManagementService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationManagementService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function index(Request $request)
    {
        $applications = $this->applicationService->getApplications(
            auth()->id(),
            $request->get('status'),
            $request->get('job_id'),
            $request->get('sort_rating'),
            $request->get('per_page')
        );
        
        $jobs = auth()->user()->jobPostings()->select('id', 'title')->get();

        return view('hr.applications.index', [
            'applications' => $applications,
            'jobs' => $jobs,
            'pageTitle' => 'Manage Applications',
        ]);
    }

    public function berkas(Application $application)
    {
        $this->authorizeOwner($application);

        $application->load(['job', 'user.workExperiences', 'user.achievements']);

        return view('hr.applications.berkas', [
            'application' => $application,
            'user' => $application->user,
            'job' => $application->job,
            'pageTitle' => 'Applicant Files: ' . $application->user->name,
        ]);
    }

    public function updateStatus(Request $request, Application $application)
    {
        $this->authorizeOwner($application);

        $request->validate([
            'status' => ['required', Rule::enum(\App\Enums\ApplicationStatus::class)],
        ]);

        $this->applicationService->updateStatus($application, $request->status);

        // Clear HR dashboard caches to ensure analytics are fresh
        cache()->forget("hr_stats_dashboard_" . auth()->id());
        cache()->forget("hr_intelligence_dashboard_" . auth()->id());

        return back()->with('flash_toast', [
            'message' => 'Application status successfully updated to ' . $request->status,
        ]);
    }

    public function refreshAi(Application $application)
    {
        $this->authorizeOwner($application);

        // Mark as processing immediately so the UI shows "Analyzing..." right away
        $application->load(['aiScore', 'aiSummary']);
        $application->aiScore?->update(['status' => 'processing', 'generated_at' => now()]);
        $application->aiSummary?->update(['status' => 'processing', 'generated_at' => now()]);

        // Bust the HR dashboard caches
        cache()->forget("hr_stats_dashboard_" . auth()->id());
        cache()->forget("hr_intelligence_dashboard_" . auth()->id());

        GenerateCvRatingJob::dispatch($application->id);
        GenerateCandidateSummaryJob::dispatch($application->id);

        return back()->with('flash_toast', [
            'message' => 'AI scoring and summary have been queued for refresh.',
        ]);
    }

    public function aiStatus(Application $application): \Illuminate\Http\JsonResponse
    {
        $this->authorizeOwner($application);

        $application->load(['aiScore', 'aiSummary']);

        $score   = $application->aiScore;
        $summary = $application->aiSummary;

        // Auto-fail jobs stuck in processing for more than 45 seconds
        $timeout = 45;
        if ($score && $score->status === 'processing' && $score->updated_at->diffInSeconds(now()) > $timeout) {
            $score->update(['status' => 'failed', 'error_message' => 'Timed out after 45 seconds.']);
            $score->refresh();
        }
        if ($summary && $summary->status === 'processing' && $summary->updated_at->diffInSeconds(now()) > $timeout) {
            $summary->update(['status' => 'failed', 'error_message' => 'Timed out after 45 seconds.']);
            $summary->refresh();
        }

        return response()->json([
            'score' => [
                'status'       => $score?->status ?? 'pending',
                'score_total'  => $score?->score_total,
                'core_strength'=> $score?->core_strength,
            ],
            'summary' => [
                'status'         => $summary?->status ?? 'pending',
                'pros'           => $summary?->pros_json ?? [],
                'cons'           => $summary?->cons_json ?? [],
                'summary_text'   => $summary?->summary_text,
                'recommendation' => $summary?->recommendation,
            ],
        ]);
    }

    protected function authorizeOwner(Application $application)
    {
        if ($application->job->created_by !== auth()->id()) {
            abort(403);
        }
    }
}
