<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Enums\Users\Account\ProviderTypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AppleAccountService;
use App\Services\Api\V1\Users\TelegramService;
use App\Services\Api\V1\Users\WalletService;
use Closure;

final class UpdateUsersInfoPipe implements PipeInterface
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly AppleAccountService $appleAccountService,
        private readonly TelegramService $telegramService,
    )
    {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($accountUuid = $dto->getAccount()->getUuid()) {

            if ($dto->getAccount()->getProviderType() !== ProviderTypeEnum::Metamask->value) {
                $this->walletService->delete(['account_uuid' => $accountUuid]);
            }

            if ($dto->getAccount()->getProviderType() !== ProviderTypeEnum::Apple->value) {
                $this->appleAccountService->delete(['account_uuid' => $accountUuid]);
            }

            if ($dto->getAccount()->getProviderType() !== ProviderTypeEnum::Telegram->value) {
                $this->telegramService->delete(['account_uuid' => $accountUuid]);
            }
        }

        return $next($dto);
    }
}
