<?php

declare(strict_types=1);

namespace App\Jobs\V1\Newsletter;

use App\Jobs\Job;
use App\Mail\V1\Newsletter\SubscriptionMail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

final class SendSubscriptionMailJob extends Job
{
    use Dispatchable;

    public function __construct(
        private readonly string $email,
    )
    {
        $this->onQueue('newsletter.subscription');
        $this->onConnection('database');
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new SubscriptionMail());
    }
}
