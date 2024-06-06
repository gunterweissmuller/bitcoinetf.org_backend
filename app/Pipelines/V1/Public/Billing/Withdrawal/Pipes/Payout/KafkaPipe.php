<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Payout;

use App\Dto\DtoInterface;
use App\Enums\Kafka\ProducerEnum;
use App\Pipelines\PipeInterface;
use App\Services\Utils\KafkaProducerService;
use Closure;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\PayoutPipelineDto;

final readonly class KafkaPipe implements PipeInterface
{
    public function handle(PayoutPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $sell = $dto->getSell();

        KafkaProducerService::handle(
            ProducerEnum::BILLING_SHARES_CLOSE,
            'user close the fund',
            [
                'entity' => 'close of the fund',
                'record' => [
                    'account_uuid' => $sell->getAccountUuid()
                ],
            ],
        );

        return $next($dto);
    }
}
