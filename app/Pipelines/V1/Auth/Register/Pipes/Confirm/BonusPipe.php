<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Referrals\InviteService;
use Closure;

final class BonusPipe implements PipeInterface
{
    public function __construct(
        private readonly InviteService $inviteService,
        private readonly PaymentService $paymentService,
    ) {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $isInvite = false;

        if ($this->inviteService->get(['account_uuid' => $dto->getAccount()->getUuid()])) {
            $isInvite = true;
        }

        $bonusAmount = $this->paymentService->get([
            'account_uuid' => $dto->getAccount()->getUuid(),
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ['bonus_wallet_uuid', '!=', null],
        ])?->getBonusAmount();

        $dto->setBonus([
            'is_invite' => $isInvite,
            'bonus_amount' => $bonusAmount,
        ]);

        return $next($dto);
    }
}
