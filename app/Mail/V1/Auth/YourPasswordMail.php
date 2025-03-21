<?php

declare(strict_types=1);

namespace App\Mail\V1\Auth;

use App\Models\Users\Account;
use App\Models\Users\Profile;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class YourPasswordMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        private readonly string $accountUuid,
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password',
        );
    }

    public function content(): Content
    {
        $account = Account::query()->where(['uuid' => $this->accountUuid])->select(['uuid', 'username'])->first();
        $profile = Profile::query()->where(['account_uuid' => $this->accountUuid])->select(['full_name'])->first();
        $firstName = explode(' ', $profile['full_name'])[0] ?? $profile['full_name'];

        return new Content(
            view: 'emails.v1.auth.your-password-v2',
            with: [
                'accountUuid' => $account['uuid'],
                'username' => $account['username'],
                'firstName' => $firstName,
                'email' => $this->email,
                'password' => $this->password,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
