<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function envelope(): Envelope
    {
        $status = ucfirst($this->application->status->value);
        return new Envelope(subject: "Your Application Status: {$status} — {$this->application->job->title}");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.application-status');
    }
}
