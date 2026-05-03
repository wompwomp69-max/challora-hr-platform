<?php

namespace App\Services\Ai;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AiGatewayService
{
    public function __construct(private HttpFactory $http)
    {
    }

    public function rateCv(array $payload): array
    {
        return $this->post('/ai/cv/rate', $payload);
    }

    public function summarizeCandidate(array $payload): array
    {
        return $this->post('/ai/candidate/summary', $payload);
    }

    public function suggestProfile(array $payload): array
    {
        return $this->post('/ai/profile/suggest', $payload);
    }

    public function recommendJobs(array $payload): array
    {
        return $this->post('/ai/jobs/recommend', $payload);
    }

    private function post(string $endpoint, array $payload): array
    {
        $requestPayload = [
            'request_id' => (string) Str::uuid(),
            'model_version' => config('ai.model_version'),
            'payload' => $payload,
        ];

        $request = $this->http
            ->baseUrl(config('ai.base_url'))
            ->acceptJson()
            ->asJson()
            ->timeout(max(1, (int) config('ai.timeout_ms') / 1000))
            ->retry((int) config('ai.retry_count'), 200);

        $token = config('ai.token');
        if (!empty($token)) {
            $request = $request->withToken($token);
        }

        try {
            $response = $request->post($endpoint, $requestPayload)->throw();
            $body = $response->json();
            if (!is_array($body)) {
                throw new \RuntimeException('AI service response is not JSON object.');
            }

            return [
                'ok' => Arr::get($body, 'status') === 'ok',
                'request_id' => Arr::get($body, 'request_id'),
                'data' => Arr::get($body, 'data', []),
                'error' => null,
            ];
        } catch (ConnectionException|RequestException $exception) {
            return [
                'ok' => false,
                'request_id' => null,
                'data' => [],
                'error' => $exception->getMessage(),
            ];
        } catch (\Throwable $exception) {
            return [
                'ok' => false,
                'request_id' => null,
                'data' => [],
                'error' => $exception->getMessage(),
            ];
        }
    }
}
