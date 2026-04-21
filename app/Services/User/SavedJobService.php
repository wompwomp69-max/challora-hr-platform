<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class SavedJobService
{
    public function getSavedJobs(int $userId): Collection
    {
        return User::findOrFail($userId)->savedJobs()->latest('saved_jobs.created_at')->get();
    }

    public function getAppliedJobIds(int $userId): array
    {
        return User::findOrFail($userId)->applications()->pluck('job_id')->toArray();
    }

    public function saveJob(User $user, int $jobId): void
    {
        $user->savedJobs()->syncWithoutDetaching([$jobId]);
    }

    public function unsaveJob(User $user, int $jobId): void
    {
        $user->savedJobs()->detach($jobId);
    }
}
