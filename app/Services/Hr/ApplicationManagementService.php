<?php

namespace App\Services\Hr;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
    }
}
