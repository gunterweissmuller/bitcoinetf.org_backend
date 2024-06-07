<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Payout;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WalletService;
use Closure;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\PayoutPipelineDto;
use App\Services\Api\V3\Billing\SellService;

final readonly class PayoutPipe implements PipeInterface
{
    public function __construct(
        private TokenService $tokenService,
        //private PaymentService $paymentService, //TODO remove
        private SellService $sellService,
    ) {
    }

    public function handle(PayoutPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $btcPrice = $this->tokenService->getBitcoinAmount();
        $sell = $this->sellService->get(['uuid' => $dto->getSell()->getUuid(),]);
        $this->sellService->update([
            'uuid' => $sell->getUuid(),
        ], [
            'status' => StatusEnum::PENDING->value
        ]);

        return $next($dto);
    }
}
