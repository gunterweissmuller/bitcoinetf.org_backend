<?php

declare(strict_types=1);

namespace App\Dto\Core;

use App\Dto\DtoInterface;

final class JwtPayloadDto implements DtoInterface
{
    public function __construct(
        private readonly ?string $uuid,
        private readonly ?int $number,
        private readonly ?string $username,
        private readonly ?string $type,
        private readonly ?string $status,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['number'] ?? null,
            $args['username'] ?? null,
            $args['type'] ?? null,
            $args['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'number' => $this->number,
            'username' => $this->username,
            'type' => $this->type,
            'status' => $this->status,
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
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }
}
