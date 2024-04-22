<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Utils\Greenfield\PullPaymentDto;
use App\Enums\Billing\Withdrawal\MethodEnum;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use App\Services\Utils\GreenfieldService;
use Closure;


final class GfPullPaymentPipe implements PipeInterface
{
    public function __construct(
        private readonly GreenfieldService $greenfieldService,
    )
    {
    }

    /**
     * @param DividendPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(DividendPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $method = $dto->getMethod();
        if ($method == MethodEnum::BITCOIN_ON_CHAIN->value || $method == MethodEnum::BITCOIN_LIGHTNING->value) {
            $payment = $dto->getPayment();

            if ($pullPayment = $this->greenfieldService->createPullPayment(PullPaymentDto::fromArray([
                'description' => 'Account UUID:' . $payment->getAccountUuid(),
                'amount' => $payment->getTotalAmountBtc(),
                'currency' => 'BTC',
                'autoApproveClaims' => true,
            ]))) {
                $dto->setPullPayment($pullPayment);
            } else {
                throw new WithdrawalNotPossibleException();
            }
        }

        return $next($dto);
    }
}
