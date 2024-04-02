<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\AuthType;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\AppleAccountDto;
use App\Enums\Auth\AuthType\StatusEnum;

final class AuthTypeApplePipelineDto implements DtoInterface
{
    public function __construct(
        private ?AppleAccountDto $appleAccount,
        private ?AccountDto $account,
        private ?StatusEnum $authType,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['apple_account'] ?? null,
            $args['account'] ?? null,
            $args['auth_type'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'apple_account' => $this->appleAccount,
            'account' => $this->account,
            'auth_type' => $this->authType,
        ];
    }

    /**
     * @return AppleAccountDto|null
     */
    public function getAppleAccount(): ?AppleAccountDto
    {
        return $this->appleAccount;
    }

    /**
     * @param AppleAccountDto|null $appleAccount
     * @return void
     */
    public function setAppleAccount(?AppleAccountDto $appleAccount): void
    {
        $this->appleAccount = $appleAccount;
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
     * @return StatusEnum|null
     */
    public function getAuthType(): ?StatusEnum
    {
        return $this->authType;
    }

    /**
     * @param  StatusEnum|null  $authType
     */
    public function setAuthType(?StatusEnum $authType): void
    {
        $this->authType = $authType;
    }
}
