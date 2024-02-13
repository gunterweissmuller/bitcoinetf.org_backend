<?php

declare(strict_types=1);

namespace App\Dto\Core;

use App\Dto\DtoInterface;

final class JwtDto implements DtoInterface
{
    public function __construct(
        private readonly string $token,
        private readonly ?string $expiresIn
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['token'],
            $args['expires_in'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'expires_in' => $this->expiresIn
        ];
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string|null
     */
    public function getExpiresIn(): ?string
    {
        return $this->expiresIn;
    }
}
