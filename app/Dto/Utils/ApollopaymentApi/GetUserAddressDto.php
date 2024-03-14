<?php

namespace App\Dto\Utils\ApollopaymentApi;

use App\Dto\DtoInterface;

class GetUserAddressDto implements DtoInterface
{
    public function __construct(
        private ?string $id, // user id in apollo
        private ?string $currency,
        private ?string $network,
        private ?bool   $renewAddress,
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
            $args['id'] ?? null,
            $args['currency'] ?? null,
            $args['network'] ?? null,
            $args['renewAddress'] ?? null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'currency' => $this->currency,
            'network' => $this->network,
            'renewAddress' => $this->renewAddress,
        ]);
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return void
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     * @return void
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string|null
     */
    public function getNetwork(): ?string
    {
        return $this->network;
    }

    /**
     * @param string|null $network
     * @return void
     */
    public function setNetwork(?string $network): void
    {
        $this->network = $network;
    }


    /**
     * @return bool|null
     */
    public function getRenewAddress(): ?bool
    {
        return $this->renewAddress;
    }

    /**
     * @param bool|null $renewAddress
     * @return void
     */
    public function setRenewAddress(?bool $renewAddress): void
    {
        $this->renewAddress = $renewAddress;
    }
}
