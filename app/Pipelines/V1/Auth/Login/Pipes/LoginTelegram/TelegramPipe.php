<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginTelegram;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginTelegramPipelineDto;
use App\Enums\Users\Telegram\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\TelegramService;
use Closure;

final class TelegramPipe implements PipeInterface
{
    public function __construct(
        private readonly TelegramService $telegramService
    )
    {
    }

    public function handle(LoginTelegramPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($telegram = $this->telegramService->get([
            'telegram_id' => $dto->getTelegram()->getTelegramId(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            $dto->setTelegram($telegram);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
