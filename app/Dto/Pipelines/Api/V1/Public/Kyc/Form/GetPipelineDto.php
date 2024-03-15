<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Kyc\Form;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\AccountDto;

final class GetPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private ?array $output,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['output'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'output' => $this->output,
        ];
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
     * @return array|null
     */
    public function getOutput(): ?array
    {
        return $this->output;
    }

    /**
     * @param  array|null  $output
     */
    public function setOutput(?array $output): void
    {
        $this->output = $output;
    }
}
