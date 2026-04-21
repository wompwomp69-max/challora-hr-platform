<?php

namespace App\Services\Hr;

use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;

class ApplicationManagementService
{
    public function getApplications(int $hrId, ?string $status, ?int $jobId): Collection
    {
        $query = Application::whereHas('job', function($q) use ($hrId) {
            $q->where('created_by', $hrId);
        })->with(['job', 'user']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($jobId) {
            $query->where('job_id', $jobId);
        }

        return $query->latest()->get();
    }

    public function updateStatus(Application $application, string $status): bool
    {
        return $application->update(['status' => $status]);
    }
}
