<?php

namespace App\Listeners\V1\Auth;

use App\Dto\Models\Auth\CodeDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Enums\Auth\Code\TypeEnum;
use App\Events\V1\Auth\OneTimeLinkEvent;
use App\Jobs\V1\Auth\SendOneTimePasswordLinkMailJob;
use App\Services\Api\V1\Auth\CodeService;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserOneTimeLinkLoginSendVerify implements ShouldQueue
{
    public function __construct(
        private readonly CodeService $codeService,
    ) {
    }

    public function handle(OneTimeLinkEvent $event): void
    {
        $code = $this->codeService->create(CodeDto::fromArray([
            'account_uuid' => $event->getEmail()->getAccountUuid(),
            'status' => StatusEnum::Dispatching->value,
            'type' => TypeEnum::OneTimePassword->value,
        ]));

        dispatch(new SendOneTimePasswordLinkMailJob($code->getUuid(), $event->getEmail()->getEmail()));
    }
}
