<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Enums\Kafka\ProducerEnum;
use App\Pipelines\PipeInterface;
use App\Services\Utils\KafkaProducerService;
use Closure;

final readonly class KafkaPipe implements PipeInterface
{
    public function handle(DividendPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $payment = $dto->getPayment();

        KafkaProducerService::handle(
            ProducerEnum::BILLING_WALLETS_WITHDRAWAL,
            'user dividends withdrawal success',
            [
                'entity' => 'withdrawals of the billing',
                'record' => [
                    'uuid' => $payment->getUuid(),
                ],
            ],
        );

        return $next($dto);
    }
}
