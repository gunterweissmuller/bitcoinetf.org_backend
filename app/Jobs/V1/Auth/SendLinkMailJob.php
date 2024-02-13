<?php

declare(strict_types=1);

namespace App\Jobs\V1\Auth;

use App\Enums\Auth\Code\StatusEnum;
use App\Jobs\Job;
use App\Mail\V1\Auth\LinkCodeMail;
use App\Services\Api\V1\Auth\CodeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

final class SendLinkMailJob extends Job
{
    public function __construct(
        private readonly string $codeUuid,
        private readonly string $email,
    ) {
    }

    public function handle(CodeService $codeService): void
    {
        if ($code = $codeService->get(['uuid' => $this->codeUuid])) {
            Mail::to($this->email)->send(new LinkCodeMail($code->getAccountUuid(), $this->email, $code->getCode()));

            $codeService->update([
                'uuid' => $code->getUuid(),
            ], [
                'status' => StatusEnum::Unused->value,
                'expires_at' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
