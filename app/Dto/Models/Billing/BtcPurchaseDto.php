<?php

declare(strict_types=1);

namespace app\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class BtcPurchaseDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?float $rate,
        private ?int $paymentsUpdated,
        private ?float $amount,
        private ?string $createdAt,
        private ?string $updatedAt
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['rate'] ?? null,
            $args['payments_updated'] ?? null,
            $args['amount'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null
        );
    }

    public function toArray(?array $without = null): array
    {
        $data = [
            'uuid' => $this->uuid,
            'rate' => $this->rate,
            'payments_updated' => $this->paymentsUpdated,
            'amount' => $this->amount,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];

        if ($without) {
            foreach ($without as $key) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param  string|null  $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return float|null
     */
    public function getRate(): ?float
    {
        return $this->rate;
    }

    /**
     * @param  float|null  $rate
     */
    public function setRate(?float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return int|null
     */
    public function getPaymentsUpdated(): ?int
    {
        return $this->paymentsUpdated;
    }

    /**
     * @param  int|null  $paymentsUpdated
     */
    public function setPaymentsUpdated(?int $paymentsUpdated): void
    {
        $this->paymentsUpdated = $paymentsUpdated;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param  float|null  $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }
 
    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param  string|null  $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param  string|null  $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}
