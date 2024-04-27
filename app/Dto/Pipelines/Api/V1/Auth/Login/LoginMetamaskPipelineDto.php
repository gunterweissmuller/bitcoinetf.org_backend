<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Login;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Models\Users\WalletDto;

final class LoginMetamaskPipelineDto implements DtoInterface
{
    public function __construct(
        private ?WalletDto   $wallet,
        private ?AccountDto  $account,
        private ?MetadataDto $metadata,
        private ?JwtDto      $jwtAccess,
        private ?JwtDto      $jwtRefresh,
        private ?string      $websocketToken = null,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['wallet'] ?? null,
            $args['account'] ?? null,
            $args['metadata'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'wallet' => $this->wallet,
            'account' => $this->account,
            'metadata' => $this->metadata,
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
     * @return WalletDto|null
     */
    public function getWallet(): ?WalletDto
    {
        return $this->wallet;
    }

    /**
     * @param WalletDto|null $wallet
     * @return void
     */
    public function setWallet(?WalletDto $wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * @return AccountDto|null
     */
    public function getAccount(): ?AccountDto
    {
        return $this->account;
    }

    /**
     * @param AccountDto|null $account
     */
    public function setAccount(?AccountDto $account): void
    {
        $this->account = $account;
    }

    /**
     * @return MetadataDto|null
     */
    public function getMetadata(): ?MetadataDto
    {
        return $this->metadata;
    }

    /**
     * @param MetadataDto|null $metadata
     * @return void
     */
    public function setMetadata(?MetadataDto $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * @return JwtDto|null
     */
    public function getJwtAccess(): ?JwtDto
    {
        return $this->jwtAccess;
    }

    /**
     * @param JwtDto|null $jwtAccess
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
     * @param JwtDto|null $jwtRefresh
     */
    public function setJwtRefresh(?JwtDto $jwtRefresh): void
    {
        $this->jwtRefresh = $jwtRefresh;
    }
}
