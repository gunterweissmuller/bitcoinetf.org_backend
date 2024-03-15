<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Token;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Auth\RefreshTokenDto;
use App\Dto\Models\Users\AccountDto;

final class RefreshPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private ?RefreshTokenDto $refreshToken,
        private ?JwtDto $jwtAccess,
        private ?JwtDto $jwtRefresh,
        private ?string $websocketToken = null
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['refresh_token'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'refresh_token' => $this->refreshToken,
            'jwt_access' => $this->jwtAccess,
            'jwt_refresh' => $this->jwtRefresh,
            'websocket_token' => $this->websocketToken,
        ];
    }

    public function getWebsocketToken(): string
    {
        return $this->websocketToken;
    }

    public function setWebsocketToken(?string $value): void
    {
        $this->websocketToken = $value;
    }

    /**
     * @return AccountDto|null
     */
    public function getAccount(): ?AccountDto
    {
        return $this->account;
    }

    /**
     * @param  AccountDto|null  $account
     */
    public function setAccount(?AccountDto $account): void
    {
        $this->account = $account;
    }

    /**
     * @return RefreshTokenDto|null
     */
    public function getRefreshToken(): ?RefreshTokenDto
    {
        return $this->refreshToken;
    }

    /**
     * @param  RefreshTokenDto|null  $refreshToken
     */
    public function setRefreshToken(?RefreshTokenDto $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return JwtDto|null
     */
    public function getJwtAccess(): ?JwtDto
    {
        return $this->jwtAccess;
    }

    /**
     * @param  JwtDto|null  $jwtAccess
     */
    public function setJwtAccess(?JwtDto $jwtAccess): void
    {
        $this->jwtAccess = $jwtAccess;
    }

    /**
     * @return JwtDto|null
     */
    public function getJwtRefresh(): ?JwtDto
    {
        return $this->jwtRefresh;
    }

    /**
     * @param  JwtDto|null  $jwtRefresh
     */
    public function setJwtRefresh(?JwtDto $jwtRefresh): void
    {
        $this->jwtRefresh = $jwtRefresh;
    }
}
