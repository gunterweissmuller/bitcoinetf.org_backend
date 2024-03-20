<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Login;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\FacebookDto;

final class LoginFacebookPipelineDto implements DtoInterface
{
    public function __construct(
        private ?FacebookDto $facebook,
        private ?AccountDto $account,
        private ?JwtDto $jwtAccess,
        private ?JwtDto $jwtRefresh,
        private ?string $websocketToken = null,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['facebook'] ?? null,
            $args['account'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'facebook' => $this->facebook,
            'account' => $this->account,
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
     * @return FacebookDto|null
     */
    public function getFacebook(): ?FacebookDto
    {
        return $this->facebook;
    }

    /**
     * @param FacebookDto|null $facebook
     * @return void
     */
    public function setFacebook(?FacebookDto $facebook): void
    {
        $this->facebook = $facebook;
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
