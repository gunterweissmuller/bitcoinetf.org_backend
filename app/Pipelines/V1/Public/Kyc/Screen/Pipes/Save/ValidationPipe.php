<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Enums\Kyc\Session\StatusEnum;
use App\Exceptions\Pipelines\V1\Kyc\FormAlreadyPassedException;
use App\Exceptions\Pipelines\V1\Kyc\ScreenAlreadyPassedException;
use App\Exceptions\Pipelines\V1\Kyc\ScreenNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Kyc\ScreenService;
use App\Services\Api\V1\Kyc\SessionResultService;
use App\Services\Api\V1\Kyc\SessionService;
use Closure;

final class ValidationPipe implements PipeInterface
{
    public function __construct(
        private readonly ScreenService $screenService,
        private readonly SessionService $sessionService,
        private readonly SessionResultService $sessionResultService,
    ) {
    }

    public function handle(SavePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $screen = $dto->getScreen();

        if (!($screen = $this->screenService->get(array_filter($screen->toArray())))) {
            throw new ScreenNotFoundException();
        }

        if ($session = $this->sessionService->get([
            'form_uuid' => $screen->getFormUuid(),
            'account_uuid' => $dto->getAccount()->getUuid(),
        ])) {
            if ($session->getStatus() == StatusEnum::Passed->value) {
                throw new FormAlreadyPassedException();
            }

            if ($this->sessionResultService->get([
                'session_uuid' => $session->getUuid(),
                'screen_uuid' => $screen->getUuid(),
            ])) {
                throw new ScreenAlreadyPassedException();
            }
        }

        return $next($dto);
    }
}
