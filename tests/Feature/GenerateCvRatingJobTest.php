<?php

namespace Tests\Feature;

use App\Jobs\Ai\GenerateCvRatingJob;
use App\Models\AiCandidateScore;
use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GenerateCvRatingJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_persists_completed_ai_score_when_service_succeeds(): void
    {
        config()->set('ai.base_url', 'http://fake-ai.local');
        config()->set('ai.retry_count', 0);

        Http::fake([
            'http://fake-ai.local/ai/cv/rate' => Http::response([
                'status' => 'ok',
                'request_id' => 'req-100',
                'data' => [
                    'score_total' => 90,
                    'score_breakdown' => ['skills' => 90],
                    'technical_reasoning' => ['Strong Laravel skills'],
                    'core_strength' => 'Backend architecture',
                    'confidence' => 0.94,
                ],
                'latency_ms' => 120,
            ], 200),
        ]);

        $hr = User::factory()->create(['role' => 'hr']);
        $candidate = User::factory()->create(['role' => 'user']);

        $job = JobPosting::create([
            'title' => 'Backend Engineer',
            'description' => 'Need Laravel and API skills',
            'job_type' => 'full_time',
            'min_education' => 'S1',
            'experience_level' => '1-3',
            'created_by' => $hr->id,
        ]);

        $application = Application::create([
            'user_id' => $candidate->id,
            'job_id' => $job->id,
            'status' => 'pending',
        ]);

        (new GenerateCvRatingJob($application->id))->handle(app(\App\Services\Ai\AiGatewayService::class));

        $score = AiCandidateScore::where('application_id', $application->id)->first();
        $this->assertNotNull($score);
        $this->assertSame('completed', $score->status);
        $this->assertSame(90, $score->score_total);
    }

    public function test_job_marks_failed_when_ai_service_errors(): void
    {
        config()->set('ai.base_url', 'http://fake-ai.local');
        config()->set('ai.retry_count', 0);

        Http::fake([
            'http://fake-ai.local/ai/cv/rate' => Http::response(['status' => 'error'], 500),
        ]);

        $hr = User::factory()->create(['role' => 'hr']);
        $candidate = User::factory()->create(['role' => 'user']);

        $job = JobPosting::create([
            'title' => 'Frontend Engineer',
            'description' => 'Need JS skills',
            'job_type' => 'full_time',
            'min_education' => 'S1',
            'experience_level' => '1-3',
            'created_by' => $hr->id,
        ]);

        $application = Application::create([
            'user_id' => $candidate->id,
            'job_id' => $job->id,
            'status' => 'pending',
        ]);

        (new GenerateCvRatingJob($application->id))->handle(app(\App\Services\Ai\AiGatewayService::class));

        $score = AiCandidateScore::where('application_id', $application->id)->first();
        $this->assertNotNull($score);
        $this->assertSame('failed', $score->status);
    }
}
