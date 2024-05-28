<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\AuthType;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\WalletConnectDto;
use App\Enums\Auth\AuthType\StatusEnum;

final class AuthTypeWalletConnectPipelineDto implements DtoInterface
{
    /**
     * @param WalletConnectDto|null $walletConnect
     * @param AccountDto|null $account
     * @param StatusEnum|null $authType
     */
    public function __construct(
        private ?WalletConnectDto $walletConnect,
        private ?AccountDto       $account,
        private ?StatusEnum       $authType,
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
            $args['auth_type'] ?? null,
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
            'auth_type' => $this->authType,
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
     * @return StatusEnum|null
     */
    public function getAuthType(): ?StatusEnum
    {
        return $this->authType;
    }

    /**
     * @param StatusEnum|null $authType
     */
    public function setAuthType(?StatusEnum $authType): void
    {
        $this->authType = $authType;
    }
}
