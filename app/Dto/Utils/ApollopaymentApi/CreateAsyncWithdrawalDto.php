<?php

namespace App\Dto\Utils\ApollopaymentApi;

use App\Dto\DtoInterface;

class CreateAsyncWithdrawalDto implements DtoInterface
{
    public function __construct(
        private ?string $advancedBalanceId,
        private ?string $addressId,
        private ?string $amount,
        private ?string $address,
        private ?string $feeToken,
        private ?string $webhookUrl,
        private ?string $tag,
    )
    {
    }

    /**
     * @param array $args
     * @return DtoInterface|self
     */
    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['advancedBalanceId'] ?? null,
            $args['addressId'] ?? null,
            $args['amount'] ?? null,
            $args['address'] ?? null,
            $args['feeToken'] ?? null,
            $args['webhookUrl'] ?? null,
            $args['tag'] ?? null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'advancedBalanceId' => $this->advancedBalanceId,
            'addressId' => $this->addressId,
            'amount' => $this->amount,
            'address' => $this->address,
            'feeToken' => $this->feeToken,
            'webhookUrl' => $this->webhookUrl,
            'tag' => $this->tag,
        ], function ($item) {
            return $item !== null;
        });
    }

    /**
     * @return string|null
     */
    public function getAdvancedBalanceId(): ?string
    {
        return $this->advancedBalanceId;
    }

    /**
     * @param string|null $advancedBalanceId
     * @return void
     */
    public function setAdvancedBalanceId(?string $advancedBalanceId): void
    {
        $this->advancedBalanceId = $advancedBalanceId;
    }

    /**
     * @return string|null
     */
    public function getAddressId(): ?string
    {
        return $this->addressId;
    }

    /**
     * @param string|null $addressId
     * @return void
     */
    public function setAddressId(?string $addressId): void
    {
        $this->addressId = $addressId;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string|null $amount
     * @return void
     */
    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return void
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getFeeToken(): ?string
    {
        return $this->feeToken;
    }

    /**
     * @param string|null $feeToken
     * @return void
     */
    public function setFeeToken(?string $feeToken): void
    {
        $this->feeToken = $feeToken;
    }

    /**
     * @return string|null
     */
    public function getWebhookUrl(): ?string
    {
        return $this->webhookUrl;
    }

    /**
     * @param string|null $webhookUrl
     * @return void
     */
    public function setWebhookUrl(?string $webhookUrl): void
    {
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string|null $tag
     * @return void
     */
    public function setTag(?string $tag): void
    {
        $this->tag = $tag;
    }
}
