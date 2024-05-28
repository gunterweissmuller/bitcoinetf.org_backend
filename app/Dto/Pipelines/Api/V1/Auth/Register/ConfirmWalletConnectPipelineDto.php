<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Register;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Models\Users\WalletConnectDto;

final class ConfirmWalletConnectPipelineDto implements DtoInterface
{
    /**
     * @param WalletConnectDto|null $walletConnect
     * @param EmailDto|null $email
     * @param CodeDto|null $code
     * @param AccountDto|null $account
     * @param MetadataDto|null $metadata
     * @param array|null $bonus
     * @param JwtDto|null $jwtAccess
     * @param JwtDto|null $jwtRefresh
     * @param string|null $websocketToken
     * @param bool|null $isFast
     */
    public function __construct(
        private ?WalletConnectDto $walletConnect,
        private ?EmailDto    $email,
        private ?CodeDto     $code,
        private ?AccountDto  $account,
        private ?MetadataDto $metadata,
        private ?array       $bonus = [],
        private ?JwtDto      $jwtAccess,
        private ?JwtDto      $jwtRefresh,
        private ?string      $websocketToken = null,
        private ?bool        $isFast
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
            $args['email'] ?? null,
            $args['code'] ?? null,
            $args['account'] ?? null,
            $args['metadata'] ?? null,
            $args['bonus'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
            $args['is_fast'] ?? false,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'wallet_connect' => $this->walletConnect,
            'email' => $this->email,
            'code' => $this->code,
            'account' => $this->account,
            'metadata' => $this->metadata,
            'bonus' => $this->bonus,
            'jwt_access' => $this->jwtAccess,
            'jwt_refresh' => $this->jwtRefresh,
            'websocket_token' => $this->websocketToken,
            'is_fast' => $this->isFast,
        ];
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
     * @return EmailDto|null
     */
    public function getEmail(): ?EmailDto
    {
        return $this->email;
    }

    /**
     * @param EmailDto|null $email
     */
    public function setEmail(?EmailDto $email): void
    {
        $this->email = $email;
    }

    /**
     * @return CodeDto|null
     */
    public function getCode(): ?CodeDto
    {
        return $this->code;
    }

    /**
     * @param CodeDto|null $code
     */
    public function setCode(?CodeDto $code): void
    {
        $this->code = $code;
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
     * @return array|null
     */
    public function getBonus(): ?array
    {
        return $this->bonus;
    }

    /**
     * @param array|null $bonus
     */
    public function setBonus(?array $bonus): void
    {
        $this->bonus = $bonus;
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

    /**
     * @return string|null
     */
    public function getWebsocketToken(): ?string
    {
        return $this->websocketToken;
    }

    /**
     * @param string|null $websocketToken
     */
    public function setWebsocketToken(?string $websocketToken): void
    {
        $this->websocketToken = $websocketToken;
    }

    public function isFast(): ?bool
    {
        return $this->isFast;
    }

    public function setIsFast(?bool $isFast): void
    {
        $this->isFast = $isFast;
    }
}
