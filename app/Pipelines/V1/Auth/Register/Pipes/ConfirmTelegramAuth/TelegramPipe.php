<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmTelegramAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmTelegramPipelineDto;
use App\Enums\Users\Telegram\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\TelegramService;
use Closure;

final class TelegramPipe implements PipeInterface
{
    public function __construct(
        private readonly TelegramService $telegramService,
    )
    {
    }

    public function handle(ConfirmTelegramPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($telegram = $this->telegramService->get(['telegram_id' => $dto->getTelegram()->getTelegramId()])) {
            $telegram->setStatus(StatusEnum::Enabled->value);

            $this->telegramService->update([
                'telegram_id' => $telegram->getTelegramId(),
            ], [
                'status' => $telegram->getStatus(),
            ]);
            $dto->setTelegram($telegram);
        }

        return $next($dto);
    }
}
