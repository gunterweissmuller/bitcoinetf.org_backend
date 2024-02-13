<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Kyc\Screen;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\FormDto;
use App\Dto\Models\Users\AccountDto;

final class AllPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private ?FormDto $form,
        private ?array $output,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['form'] ?? null,
            $args['output'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'form' => $this->form,
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
     * @return FormDto|null
     */
    public function getForm(): ?FormDto
    {
        return $this->form;
    }

    /**
     * @param  FormDto|null  $form
     */
    public function setForm(?FormDto $form): void
    {
        $this->form = $form;
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
