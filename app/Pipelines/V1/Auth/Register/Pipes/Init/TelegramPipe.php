<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitTelegramPipelineDto;
use App\Enums\Users\Telegram\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\TelegramService;
use Closure;

final class TelegramPipe implements PipeInterface
{
    public function __construct(
        private readonly TelegramService $telegramService,
    ) {
    }

    public function handle(InitTelegramPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$telegram = $this->telegramService->get([
            'telegram_id' => $dto->getTelegram()->getTelegramId(),
        ])) {
            $telegram = $dto->getTelegram();
            $telegram->setAccountUuid($dto->getAccount()->getUuid());
            $telegram->setStatus(StatusEnum::AwaitConfirm->value);
            $telegram->setTelegramId($dto->getTelegram()->getTelegramId());

            $telegram = $this->telegramService->create($telegram);
        }

        $dto->setTelegram($telegram);
        return $next($dto);
    }
}
