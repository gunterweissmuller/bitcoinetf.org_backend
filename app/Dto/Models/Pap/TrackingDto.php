<?php

declare(strict_types=1);

namespace App\Dto\Models\Pap;

use App\Dto\DtoInterface;

final class TrackingDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $event_type,
        private ?string $pap_id,
        private ?string $utm_label,
        private ?string $real_amount,
        private ?string $amount_type,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['event_type'] ?? null,
            $args['pap_id'] ?? null,
            $args['utm_label'] ?? null,
            $args['real_amount'] ?? null,
            $args['amount_type'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'event_type' => $this->event_type,
            'pap_id' => $this->pap_id,
            'utm_label' => $this->utm_label,
            'real_amount' => $this->real_amount,
            'amount_type' => $this->amount_type,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
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
     * @return string|null
     */
    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    /**
     * @param  string|null  $accountUuid
     */
    public function setAccountUuid(?string $accountUuid): void
    {
        $this->accountUuid = $accountUuid;
    }

    /**
     * @return string|null
     */
    public function getEventType(): ?string
    {
        return $this->event_type;
    }

    /**
     * @param string|null $event_type
     * @return void
     */
    public function setEventType(?string $event_type): void
    {
        $this->event_type = $event_type;
    }

    /**
     * @return string|null
     */
    public function getPapId(): ?string
    {
        return $this->pap_id;
    }

    /**
     * @param  string|null  $pap_id
     */
    public function setPapId(?string $pap_id): void
    {
        $this->pap_id = $pap_id;
    }

    /**
     * @return string|null
     */
    public function getUtmLabel(): ?string
    {
        return $this->utm_label;
    }

    /**
     * @param  string|null  $utm_label
     */
    public function setUtmLabel(?string $utm_label): void
    {
        $this->utm_label = $utm_label;
    }

    /**
     * @return string|null
     */
    public function getRealAmount(): ?string
    {
        return $this->real_amount;
    }

    /**
     * @param  string|null  $real_amount
     */
    public function setRealAmount(?string $real_amount): void
    {
        $this->real_amount = $real_amount;
    }

    /**
     * @return string|null
     */
    public function getAmountType(): ?string
    {
        return $this->amount_type;
    }

    /**
     * @param  string|null  $amount_type
     */
    public function setAmountType(?string $amount_type): void
    {
        $this->amount_type = $amount_type;
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
