<?php

namespace App\Services\Hr;

<<<<<<< HEAD
use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
=======
use App\Models\Application;
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApplicationManagementService
{
<<<<<<< HEAD
    public function getApplications(int $hrId, ?string $status, ?int $jobId, ?string $sortRating = null): LengthAwarePaginator
    {
        $query = Application::whereHas('job', function($q) use ($hrId) {
            $q->where('created_by', $hrId);
        })->with(['job', 'user', 'aiScore']);
=======
    public function getApplications(int $hrId, ?string $status, ?int $jobId): LengthAwarePaginator
    {
        $query = Application::whereHas('job', function($q) use ($hrId) {
            $q->where('created_by', $hrId);
        })->with(['job', 'user']);
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d

        if ($status) {
            $query->where('status', $status);
        }

        if ($jobId) {
            $query->where('job_id', $jobId);
        }

<<<<<<< HEAD
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
=======
        return $query->latest()->paginate(10);
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
    }

    public function updateStatus(Application $application, string $status): bool
    {
<<<<<<< HEAD
        $updated = $application->update(['status' => $status]);

        if ($updated) {
            // Dashboard stats are cached per HR; clear cache so analytics reflects latest status immediately.
            $application->loadMissing('job:id,created_by');
            Cache::forget('hr_dashboard_' . $application->job->created_by);

            $this->sendStatusEmailIfNeeded($application, $status);
        }

        return $updated;
    }

    protected function sendStatusEmailIfNeeded(Application $application, string $status): void
    {
        if (!in_array($status, [ApplicationStatus::ACCEPTED->value, ApplicationStatus::REJECTED->value], true)) {
            return;
        }

        $application->loadMissing('user:id,name,email', 'job:id,title');
        $candidate = $application->user;
        $job = $application->job;

        if (!$candidate || !$candidate->email || !$job) {
            return;
        }

        $isAccepted = $status === ApplicationStatus::ACCEPTED->value;
        $subject = $isAccepted
            ? 'Selamat! Lamaran Anda Diterima'
            : 'Update Lamaran: Belum Lolos Tahap Ini';
        $statusText = $isAccepted ? 'DITERIMA' : 'BELUM LOLOS';
        $messageText = $isAccepted
            ? 'Selamat, profil Anda dinyatakan sesuai dan Anda lolos ke tahap berikutnya.'
            : 'Terima kasih sudah melamar. Untuk saat ini Anda belum lolos pada tahap ini.';

        Mail::html(
            view('emails.application-status', [
                'candidateName' => $candidate->name,
                'jobTitle' => $job->title,
                'statusText' => $statusText,
                'messageText' => $messageText,
            ])->render(),
            function ($mail) use ($candidate, $subject) {
                $mail->to($candidate->email, $candidate->name)->subject($subject);
            }
        );
=======
        return $application->update(['status' => $status]);
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
    }
}
