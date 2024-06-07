<?php

declare(strict_types=1);

namespace App\Jobs\V1\Billing\Report;

use App\Jobs\Job;
use App\Mail\V1\Billing\MonthlyDividendStatementMail;
use Illuminate\Support\Facades\Mail;

final class SendMonthlyDividendStatementMailJob extends Job
{
    public function __construct(
        private readonly string $accountUuid,
        private readonly string $email,
        private readonly string $reportUuid,
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new MonthlyDividendStatementMail($this->accountUuid, $this->reportUuid));
    }
}
