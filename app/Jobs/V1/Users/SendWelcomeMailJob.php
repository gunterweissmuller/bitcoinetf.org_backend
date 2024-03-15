<?php

declare(strict_types=1);

namespace App\Jobs\V1\Users;

use App\Jobs\Job;
use App\Mail\V1\Users\WelcomeMail;
use Illuminate\Support\Facades\Mail;

final class SendWelcomeMailJob extends Job
{
    public function __construct(
        private readonly string $accountUuid,
        private readonly string $email,
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new WelcomeMail($this->accountUuid));
    }
}
