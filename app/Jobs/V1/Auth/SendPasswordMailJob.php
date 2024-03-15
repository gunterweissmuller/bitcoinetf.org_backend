<?php

declare(strict_types=1);

namespace App\Jobs\V1\Auth;

use App\Jobs\Job;
use App\Mail\V1\Auth\YourPasswordMail;
use Illuminate\Support\Facades\Mail;

final class SendPasswordMailJob extends Job
{
    public function __construct(
        private readonly string $accountUuid,
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new YourPasswordMail($this->accountUuid, $this->email, $this->password));
    }
}
