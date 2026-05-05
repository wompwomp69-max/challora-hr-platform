<?php

return [
    'base_url' => env('AI_SERVICE_BASE_URL', 'http://127.0.0.1:8001'),
    'token' => env('AI_SERVICE_TOKEN'),
    'timeout_ms' => (int) env('AI_TIMEOUT_MS', 15000),
    'retry_count' => (int) env('AI_RETRY_COUNT', 1),
    'model_version' => env('AI_MODEL_VERSION', 'gemini-2.5-flash-lite'),
];
