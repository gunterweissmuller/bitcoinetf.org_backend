<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitAppleAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Enums\Kafka\ProducerEnum;
use App\Pipelines\PipeInterface;
use App\Services\Utils\KafkaProducerService;
use Closure;

final class EventsPipe implements PipeInterface
{
    public function handle(InitApplePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();

        KafkaProducerService::handle(
            ProducerEnum::AUTH_REGISTRATION,
            'user initiated registration',
            [
                'entity' => 'users.account',
                'record' => [
                    'uuid' => $account->getUuid(),
                    'number' => $account->getNumber(),
                    'username' => $account->getUsername(),
                    'type' => $account->getType(),
                    'status' => $account->getStatus(),
                    'created_at' => $account->getCreatedAt(),
                    'updated_at' => $account->getUpdatedAt(),
                ],
            ]
        );

        return $next($dto);
    }
}
