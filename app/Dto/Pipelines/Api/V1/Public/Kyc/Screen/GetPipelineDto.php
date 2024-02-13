<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Kyc\Screen;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\ScreenDto;
use App\Dto\Models\Users\AccountDto;

final class GetPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private ?ScreenDto $screen,
        private ?array $output,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['screen'] ?? null,
            $args['output'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'screen' => $this->screen,
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
     * @return ScreenDto|null
     */
    public function getScreen(): ?ScreenDto
    {
        return $this->screen;
    }

    /**
     * @param  ScreenDto|null  $screen
     */
    public function setScreen(?ScreenDto $screen): void
    {
        $this->screen = $screen;
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
