<?php

namespace App\Dto\Utils\ApollopaymentApi;

use App\Dto\DtoInterface;

class GetUserAllAddressesDto implements DtoInterface
{
    public function __construct(
        private ?string $id, // user id in apollo
        private ?array $currency,
        private ?array $network,
        private ?int    $offset = 0,
        private ?int    $limit = 1000000,
        private ?bool   $isActive = true,
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
            $args['offset'] ?? 0,
            $args['limit'] ?? 1000000,
            $args['isActive'] ?? true,
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
            'offset' => $this->offset,
            'limit' => $this->limit,
            'isActive' => $this->isActive,
        ], function ($item) {
            return $item !== null;
        });
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
     * @return array|null
     */
    public function getCurrency(): ?array
    {
        return $this->currency;
    }

    /**
     * @param array|null $currency
     * @return void
     */
    public function setCurrency(?array $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return array|null
     */
    public function getNetwork(): ?array
    {
        return $this->network;
    }

    /**
     * @param array|null $network
     * @return void
     */
    public function setNetwork(?array $network): void
    {
        $this->network = $network;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     * @return void
     */
    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     * @return void
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool|null $isActive
     * @return void
     */
    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }
}
