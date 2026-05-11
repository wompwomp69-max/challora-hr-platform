<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class GmailApiTransport extends AbstractTransport
{
    public function __construct(
        private string $clientId,
        private string $clientSecret,
        private string $refreshToken,
    ) {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $accessToken = $this->getAccessToken();

        $email   = MessageConverter::toEmail($message->getOriginalMessage());
        $raw     = base64_encode($message->toString());
        $raw     = str_replace(['+', '/', '='], ['-', '_', ''], $raw);

        $response = Http::withToken($accessToken)
            ->post('https://gmail.googleapis.com/gmail/v1/users/me/messages/send', [
                'raw' => $raw,
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('Gmail API error: ' . $response->body());
        }
    }

    private function getAccessToken(): string
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $this->refreshToken,
            'grant_type'    => 'refresh_token',
        ]);

        if (!$response->successful() || empty($response->json('access_token'))) {
            throw new \RuntimeException('Failed to get Gmail access token: ' . $response->body());
        }

        return $response->json('access_token');
    }

    public function __toString(): string
    {
        return 'gmail-api';
    }
}
