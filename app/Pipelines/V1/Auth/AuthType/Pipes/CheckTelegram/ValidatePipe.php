<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\AuthType\Pipes\CheckTelegram;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeTelegramPipelineDto;
use App\Enums\Auth\AuthType\StatusEnum as AuthTypeStatusEnum;
use App\Enums\Users\Telegram\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\TelegramService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    public function __construct(
        private readonly TelegramService $telegramService,
    ) {
    }

    public function handle(AuthTypeTelegramPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $telegram = $this->telegramService->get([
            'telegram_id' => $dto->getTelegram()->getTelegramId(),
        ]);

        if (!$telegram) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($telegram->getStatus() === StatusEnum::AwaitConfirm->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($telegram->getStatus() === StatusEnum::Enabled->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Login);
        } else {
            throw new UserAlreadyExistException();
        }

        return $next($dto);
    }
}
