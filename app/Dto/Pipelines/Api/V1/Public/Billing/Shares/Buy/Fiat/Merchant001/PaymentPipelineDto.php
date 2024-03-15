<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\ReplenishmentDto;

final class PaymentPipelineDto implements DtoInterface
{
    public function __construct(
        private ReplenishmentDto $replenishment,
        private string $method,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['replenishment'] ?? null,
            $args['method'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'replenishment' => $this->replenishment,
            'method' => $this->method,
        ];
    }

    public function getReplenishment(): ReplenishmentDto
    {
        return $this->replenishment;
    }

    public function setReplenishment(ReplenishmentDto $replenishment): void
    {
        $this->replenishment = $replenishment;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }
}
