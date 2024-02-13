<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\SessionDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Enums\Kyc\Session\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Kyc\SessionService;
use Closure;

final class SessionPipe implements PipeInterface
{
    public function __construct(
        private readonly SessionService $sessionService,
    ) {
    }

    public function handle(SavePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();
        $screen = $dto->getScreen();

        if (!($session = $this->sessionService->get([
            'account_uuid' => $account->getUuid(),
            'form_uuid' => $screen->getFormUuid(),
        ]))) {
            $session = $this->sessionService->create(SessionDto::fromArray([
                'form_uuid' => $screen->getFormUuid(),
                'account_uuid' => $account->getUuid(),
                'status' => StatusEnum::InProcess->value,
            ]));
        }

        $dto->setSession($session);

        return $next($dto);
    }
}
