<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Recovery;

use App\Dto\DtoInterface;
use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;

final class ConfirmPipelineDto implements DtoInterface
{
    public function __construct(
        private ?CodeDto $code,
        private ?AccountDto $account,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['code'] ?? null,
            $args['account'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'account' => $this->account,
        ];
    }

    /**
     * @return CodeDto|null
     */
    public function getCode(): ?CodeDto
    {
        return $this->code;
    }

    /**
     * @param  CodeDto|null  $code
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
     * @param  AccountDto|null  $account
     */
    public function setAccount(?AccountDto $account): void
    {
        $this->account = $account;
    }
}
