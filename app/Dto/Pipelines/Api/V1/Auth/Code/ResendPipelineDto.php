<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Code;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;

final class ResendPipelineDto implements DtoInterface
{
    public function __construct(
        private ?EmailDto $email,
        private ?AccountDto $account,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['email'] ?? null,
            $args['account'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'account' => $this->account,
        ];
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
}
