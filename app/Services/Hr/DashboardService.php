<?php

namespace App\Services\Hr;

use App\Models\Application;
use App\Models\JobPosting;
<<<<<<< HEAD
=======
use App\Models\User;
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getDashboardData(int $hrId): array
    {
        return cache()->remember("hr_dashboard_{$hrId}", now()->addMinutes(10), function () use ($hrId) {
<<<<<<< HEAD
            $driver = DB::connection()->getDriverName();
=======
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
            $jobs = JobPosting::where('created_by', $hrId)->pluck('id');
            $totalJobs = $jobs->count();
            
            $stats = Application::whereIn('job_id', $jobs)
                ->selectRaw("
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) as accepted,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
                ")
                ->first();

<<<<<<< HEAD
            // Group by job location to avoid fragmented free-text user addresses.
            $topRegions = JobPosting::query()
                ->whereIn('job_postings.id', $jobs)
                ->join('applications', 'applications.job_id', '=', 'job_postings.id')
                ->selectRaw("COALESCE(NULLIF(job_postings.location, ''), 'Unknown') as region")
                ->selectRaw('COUNT(applications.id) as total')
                ->groupBy('region')
=======
            // 2. Top Regions (Calculated from user addresses)
            $topRegions = User::whereHas('applications', function($q) use ($jobs) {
                    $q->whereIn('job_id', $jobs);
                })
                ->select('address as region', DB::raw('count(*) as total'))
                ->groupBy('address')
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
                ->orderByDesc('total')
                ->limit(5)
                ->get();

<<<<<<< HEAD
            // Monthly trend currently relies on MySQL functions for grouped month labels.
            if ($driver === 'mysql') {
                $monthlyTrend = Application::whereIn('job_id', $jobs)
                    ->selectRaw("DATE_FORMAT(created_at, '%b %Y') as month_label, COUNT(*) as total, SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) as accepted")
                    ->where('created_at', '>=', now()->subMonths(6))
                    ->groupBy('month_label', DB::raw('MONTH(created_at)'))
                    ->orderBy(DB::raw('MONTH(created_at)'))
                    ->get();
            } else {
                $monthlyTrend = collect();
            }
=======
            // 3. Monthly Trend (Applications over last 6 months)
            $monthlyTrend = Application::whereIn('job_id', $jobs)
                ->selectRaw("DATE_FORMAT(created_at, '%b %Y') as month_label, COUNT(*) as total, SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) as accepted")
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month_label', DB::raw('MONTH(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'))
                ->get();
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d

            // 4. Jobs by Applicants
            $jobsWithStats = JobPosting::where('created_by', $hrId)
                ->withCount(['applications as applicant_count', 'applications as accepted_count' => function($q) {
                    $q->where('status', 'accepted');
                }])
                ->orderByDesc('applicant_count')
                ->limit(5)
                ->get();

            return [
                'totalJobs' => $totalJobs,
                'stats' => $stats,
                'topRegions' => $topRegions,
                'monthlyTrend' => $monthlyTrend,
                'jobsByApplicants' => $jobsWithStats,
            ];
        });
    }
}
