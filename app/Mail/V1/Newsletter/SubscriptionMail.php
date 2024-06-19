<?php

declare(strict_types=1);

namespace App\Mail\V1\Newsletter;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class SubscriptionMail extends Mailable
{
    use SerializesModels;

    public function __construct()
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'News letter',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.v1.newsletter.subscription',
            with: [],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
