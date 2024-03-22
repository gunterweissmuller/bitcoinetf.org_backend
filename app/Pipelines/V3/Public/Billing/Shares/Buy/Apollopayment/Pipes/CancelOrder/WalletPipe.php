<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment\Pipes\CancelOrder;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Apollopayment\CancelOrderPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final readonly class WalletPipe implements PipeInterface
{
    public function __construct(
        private WalletService $walletService,
    ) {
    }

    public function handle(CancelOrderPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        return $next($dto);
    }
}
