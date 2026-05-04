<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Jobs\Ai\GenerateCandidateSummaryJob;
use App\Jobs\Ai\GenerateCvRatingJob;
=======
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
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
<<<<<<< HEAD
            $request->get('job_id'),
            $request->get('sort_rating')
=======
            $request->get('job_id')
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
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

        return back()->with('flash_toast', [
            'message' => 'Application status successfully updated to ' . $request->status,
        ]);
    }

<<<<<<< HEAD
    public function refreshAi(Application $application)
    {
        $this->authorizeOwner($application);

        GenerateCvRatingJob::dispatch($application->id);
        GenerateCandidateSummaryJob::dispatch($application->id);

        return back()->with('flash_toast', [
            'message' => 'AI scoring and summary have been queued for refresh.',
        ]);
    }

=======
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
    protected function authorizeOwner(Application $application)
    {
        if ($application->job->created_by !== auth()->id()) {
            abort(403);
        }
    }
}
