<?php

namespace App\Dto\Utils\ApollopaymentApi;

use App\Dto\DtoInterface;

class GetCommissionWithdrawalDto implements DtoInterface
{
    public function __construct(
        private ?string $advancedBalanceId,
        private ?string $addressId,
        private ?string $amount,
        private ?bool   $native = false,
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
            $args['native'] ?? false,
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
            'native' => $this->native,
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
     * @return bool|null
     */
    public function getNative(): ?bool
    {
        return $this->native;
    }

    /**
     * @param bool|null $native
     * @return void
     */
    public function setNative(?bool $native): void
    {
        $this->native = $native;
    }
}
