<?php

namespace Tests\Unit;

use App\Services\Ai\AiGatewayService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiGatewayServiceTest extends TestCase
{
    public function test_rate_cv_returns_normalized_success_payload(): void
    {
        config()->set('ai.base_url', 'http://fake-ai.local');
        config()->set('ai.token', null);
        config()->set('ai.retry_count', 0);

        Http::fake([
            'http://fake-ai.local/ai/cv/rate' => Http::response([
                'status' => 'ok',
                'request_id' => 'req-1',
                'data' => ['score_total' => 88],
                'latency_ms' => 45,
            ], 200),
        ]);

        $service = app(AiGatewayService::class);
        $result = $service->rateCv([
            'job_description' => 'Backend engineer',
            'candidate_name' => 'John',
            'candidate_profile' => [],
        ]);

        $this->assertTrue($result['ok']);
        $this->assertSame(88, $result['data']['score_total']);
    }
}
