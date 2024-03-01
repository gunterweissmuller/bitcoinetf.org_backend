<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\AuthType;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\TelegramDto;
use App\Enums\Auth\AuthType\StatusEnum;

final class AuthTypeTelegramPipelineDto implements DtoInterface
{
    public function __construct(
        private ?TelegramDto $telegram,
        private ?AccountDto $account,
        private ?StatusEnum $authType,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['telegram'] ?? null,
            $args['account'] ?? null,
            $args['auth_type'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'telegram' => $this->telegram,
            'account' => $this->account,
            'auth_type' => $this->authType,
        ];
    }

    /**
     * @return TelegramDto|null
     */
    public function getTelegram(): ?TelegramDto
    {
        return $this->telegram;
    }

    /**
     * @param TelegramDto|null $telegram
     * @return void
     */
    public function setTelegram(?TelegramDto $telegram): void
    {
        $this->telegram = $telegram;
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
