<?php

namespace App\Listeners\V1\Auth;

use App\Dto\Models\Auth\CodeDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Enums\Auth\Code\TypeEnum;
use App\Events\V1\Auth\ResendCodeEvent;
use App\Events\V1\Users\NewUserEvent;
use App\Jobs\V1\Auth\SendCodeMailJob;
use App\Services\Api\V1\Auth\CodeService;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserSendVerify implements ShouldQueue
{
    public function __construct(
        private readonly CodeService $codeService,
    ) {
    }

    public function handle(NewUserEvent|ResendCodeEvent $event): void
    {
        $code = $this->codeService->create(CodeDto::fromArray([
            'account_uuid' => $event->getAccount()->getUuid(),
            'status' => StatusEnum::Dispatching->value,
            'type' => TypeEnum::Registration->value,
        ]));

        dispatch(new SendCodeMailJob($code->getUuid(), $event->getEmail()->getEmail()));
    }
}
