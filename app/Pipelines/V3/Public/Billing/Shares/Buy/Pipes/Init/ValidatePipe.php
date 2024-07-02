<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotAvailableException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;

final readonly class ValidatePipe implements PipeInterface
{
    public function __construct(
        private AccountService $accountService,
    )
    {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $this->accountService->get(['uuid' => $dto->getAccount()->getUuid()]);
        if ($account->getOrderType() != null && $account->getOrderType() != $dto->getReplenishment()->getOrderType()) {
            throw new ReplenishmentNotAvailableException();
        }
        $dto->setAccount($account);

        return $next($dto);
    }
}
