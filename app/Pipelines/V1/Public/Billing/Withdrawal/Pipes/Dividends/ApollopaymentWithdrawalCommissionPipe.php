<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Utils\ApollopaymentApi\GetCommissionWithdrawalDto;
use App\Enums\Billing\Withdrawal\MethodEnum;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use App\Services\Utils\ApollopaymentApiService;
use Closure;

final class ApollopaymentWithdrawalCommissionPipe implements PipeInterface
{
    public function __construct(
        private readonly ApollopaymentApiService $apollopaymentApiService,
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
        if ($dto->getMethod() == MethodEnum::POLYGON_USDT->value) {
            try {
                $payment = $dto->getPayment();

                $commissionWithdrawalDto = GetCommissionWithdrawalDto::fromArray([
                    'advancedBalanceId' => env('APOLLO_PAYMENT_ADVANCED_BALANCE_ID'),
                    'addressId' => env('APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS_ID'),
                    'amount' => $payment->getDividendAmount(),
                ]);

                $commissionData = $this->apollopaymentApiService->getCommissionWithdrawal($commissionWithdrawalDto);

                if ($commissionData['success'] && $commissionData['response']) {
                    $dto->setApollopaymentWithdrawalFeeToken($commissionData['response']['token']);
                } else {
                    throw new WithdrawalNotPossibleException('Apollo payment response is null');
                }
            } catch (\Exception $e) {
                throw new WithdrawalNotPossibleException($e->getMessage());
            }
        }
        return $next($dto);
    }
}
