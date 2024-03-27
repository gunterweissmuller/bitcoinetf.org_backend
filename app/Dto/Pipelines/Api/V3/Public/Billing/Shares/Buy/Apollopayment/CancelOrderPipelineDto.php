<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\ReplenishmentDto;

class CancelOrderPipelineDto implements DtoInterface
{
    public function __construct(
        private ?ReplenishmentDto $replenishment,
    ) {
    }

    /**
     * @param array $args
     * @return self
     */
    public static function fromArray(array $args): self
    {
        return new self(
            $args['replenishment'] ?? null,
        );
    }

    /**
     * @return ReplenishmentDto[]|null[]
     */
    public function toArray(): array
    {
        return [
            'replenishment' => $this->replenishment,
        ];
    }

    /**
     * @return ReplenishmentDto|null
     */
    public function getReplenishment(): ?ReplenishmentDto
    {
        return $this->replenishment;
    }

    /**
     * @param ReplenishmentDto|null $replenishment
     * @return void
     */
    public function setReplenishment(?ReplenishmentDto $replenishment): void
    {
        $this->replenishment = $replenishment;
    }
}
