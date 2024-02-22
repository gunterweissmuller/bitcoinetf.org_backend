<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final readonly class WalletPipe implements PipeInterface
{
    public function __construct(
        private WalletService $walletService,
    ) {
    }

    public function handle(DividendPipelineDto|ReferralPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($wallet = $this->walletService->get(array_filter($dto->getWallet()->toArray()))) {
            $dto->setWallet($wallet);
        } else {
            throw new WithdrawalNotPossibleException();
        }

        return $next($dto);
    }
}
