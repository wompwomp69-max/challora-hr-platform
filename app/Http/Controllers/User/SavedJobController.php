<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Services\User\SavedJobService;

class SavedJobController extends Controller
{
    protected $savedJobService;

    public function __construct(SavedJobService $savedJobService)
    {
        $this->savedJobService = $savedJobService;
    }

    public function index()
    {
        $userId = auth()->id();
        $jobs = $this->savedJobService->getSavedJobs($userId);
        $appliedJobIds = $this->savedJobService->getAppliedJobIds($userId);

        return view('user.jobs.saved', [
            'jobs' => $jobs,
            'appliedJobIds' => $appliedJobIds,
            'pageTitle' => 'Lowongan Tersimpan',
        ]);
    }

    public function save(JobPosting $job)
    {
        $this->savedJobService->saveJob(auth()->user(), $job->id);

        return back()->with('flash_toast', [
            'message' => 'Lowongan berhasil disimpan.',
        ]);
    }

    public function unsave(JobPosting $job)
    {
        $this->savedJobService->unsaveJob(auth()->user(), $job->id);

        return back()->with('flash_toast', [
            'message' => 'Lowongan dihapus dari daftar tersimpan.',
        ]);
    }
}
