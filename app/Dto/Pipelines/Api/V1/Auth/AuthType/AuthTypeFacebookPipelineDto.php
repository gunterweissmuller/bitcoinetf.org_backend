<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\AuthType;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\FacebookDto;
use App\Enums\Auth\AuthType\StatusEnum;

final class AuthTypeFacebookPipelineDto implements DtoInterface
{
    public function __construct(
        private ?FacebookDto $facebook,
        private ?AccountDto $account,
        private ?StatusEnum $authType,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['facebook'] ?? null,
            $args['account'] ?? null,
            $args['auth_type'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'facebook' => $this->facebook,
            'account' => $this->account,
            'auth_type' => $this->authType,
        ];
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
