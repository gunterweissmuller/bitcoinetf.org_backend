<?php

namespace App\Dto\Utils\ApollopaymentApi;

use App\Dto\DtoInterface;

class GetUserDto implements DtoInterface
{
    public function __construct(
        private ?string $id, // user id in apollo
        private ?string $clientId // account uuid
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
            $args['clientId'] ?? null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'clientId' => $this->clientId,
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
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * @param string|null $clientId
     * @return void
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }
}
