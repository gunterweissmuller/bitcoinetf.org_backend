<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Login;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Models\Users\WalletConnectDto;

final class LoginWalletConnectPipelineDto implements DtoInterface
{
    /**
     * @param WalletConnectDto|null $walletConnect
     * @param AccountDto|null $account
     * @param MetadataDto|null $metadata
     * @param JwtDto|null $jwtAccess
     * @param JwtDto|null $jwtRefresh
     * @param string|null $websocketToken
     */
    public function __construct(
        private ?WalletConnectDto $walletConnect,
        private ?AccountDto       $account,
        private ?MetadataDto      $metadata,
        private ?JwtDto           $jwtAccess,
        private ?JwtDto           $jwtRefresh,
        private ?string           $websocketToken = null,
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
            $args['wallet_connect'] ?? null,
            $args['account'] ?? null,
            $args['metadata'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'wallet_connect' => $this->walletConnect,
            'account' => $this->account,
            'metadata' => $this->metadata,
            'jwt_access' => $this->jwtAccess,
            'jwt_refresh' => $this->jwtRefresh,
            'websocket_token' => $this->websocketToken,
        ];
    }

    /**
     * @return string
     */
    public function getWebsocketToken(): string
    {
        return $this->websocketToken;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setWebsocketToken(?string $value): void
    {
        $this->websocketToken = $value;
    }

    /**
     * @return WalletConnectDto|null
     */
    public function getWalletConnect(): ?WalletConnectDto
    {
        return $this->walletConnect;
    }

    /**
     * @param WalletConnectDto|null $walletConnect
     * @return void
     */
    public function setWalletConnect(?WalletConnectDto $walletConnect): void
    {
        $this->walletConnect = $walletConnect;
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
