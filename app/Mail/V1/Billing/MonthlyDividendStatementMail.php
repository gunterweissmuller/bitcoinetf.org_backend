<?php

declare(strict_types=1);

namespace App\Mail\V1\Billing;

use App\Models\Users\Account;
use App\Models\Users\Profile;
use App\Services\Api\V1\Statistic\ReportService;
use App\Services\Api\V1\Storage\FileService;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class MonthlyDividendStatementMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        private readonly string $accountUuid,
        private readonly string $reportUuid,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Monthly Dividend Statement is Ready',
        );
    }

    public function content(): Content
    {
        $account = Account::query()->where(['uuid' => $this->accountUuid])->select(['uuid', 'username'])->first();
        if ($profile = Profile::query()->where(['account_uuid' => $this->accountUuid])->select(['full_name'])->first()) {
            $firstName = explode(' ', $profile['full_name'])[0] ?? $profile['full_name'];
        } else {
            $firstName = '';
        }

        $reportService = app(ReportService::class);
        $fileService = app(FileService::class);
        $report = $reportService->get([
            'uuid' => $this->reportUuid
        ]);
        $file = $fileService->get(['uuid' => $report->getFileUuid()], true);

        $downloadUrl = env('APP_URL') . '/v1/public/statistic/monthly-dividends-report/' . $file->getUuid();

        return new Content(
            view: 'emails.v1.billing.monthly-statement',
            with: [
                'accountUuid' => $account['uuid'],
                'username' => $account['username'],
                'firstName' => $firstName,
                'downloadUrl' => $downloadUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
