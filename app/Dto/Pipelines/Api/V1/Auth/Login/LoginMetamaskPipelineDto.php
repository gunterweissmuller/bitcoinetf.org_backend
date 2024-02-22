<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Login;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\WalletDto;

final class LoginMetamaskPipelineDto implements DtoInterface
{
    public function __construct(
        private ?EmailDto $email,
        private ?AccountDto $account,
        private ?JwtDto $jwtAccess,
        private ?JwtDto $jwtRefresh,
        private ?string $websocketToken = null,
        private ?WalletDto $wallet,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['email'] ?? null,
            $args['account'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
            $args['wallet'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'account' => $this->account,
            'jwt_access' => $this->jwtAccess,
            'jwt_refresh' => $this->jwtRefresh,
            'websocket_token' => $this->websocketToken,
            'wallet' => $this->wallet,
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
     * @return EmailDto|null
     */
    public function getEmail(): ?EmailDto
    {
        return $this->email;
    }

    /**
     * @param  EmailDto|null  $email
     */
    public function setEmail(?EmailDto $email): void
    {
        $this->email = $email;
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

    /**
     * @return WalletDto|null
     */
    public function getWallet(): ?WalletDto
    {
        return $this->wallet;
    }

    /**
     * @param  WalletDto|null  $email
     */
    public function setWallet(?WalletDto $wallet): void
    {
        $this->wallet = $wallet;
    }
}
