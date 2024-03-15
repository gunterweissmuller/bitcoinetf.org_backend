<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Kyc\Screen;

use App\Dto\DtoInterface;
use App\Dto\Models\Kyc\ScreenDto;
use App\Dto\Models\Kyc\SessionDto;
use App\Dto\Models\Kyc\SessionResultDto;
use App\Dto\Models\Users\AccountDto;

final class SavePipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto $account,
        private ?ScreenDto $screen,
        private ?SessionDto $session,
        private ?SessionResultDto $sessionResult,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? null,
            $args['screen'] ?? null,
            $args['session'] ?? null,
            $args['session_result'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'screen' => $this->screen,
            'session' => $this->session,
            'session_result' => $this->sessionResult,
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
     * @return SessionDto|null
     */
    public function getSession(): ?SessionDto
    {
        return $this->session;
    }

    /**
     * @param  SessionDto|null  $session
     */
    public function setSession(?SessionDto $session): void
    {
        $this->session = $session;
    }

    /**
     * @return SessionResultDto|null
     */
    public function getSessionResult(): ?SessionResultDto
    {
        return $this->sessionResult;
    }

    /**
     * @param  SessionResultDto|null  $sessionResult
     */
    public function setSessionResult(?SessionResultDto $sessionResult): void
    {
        $this->sessionResult = $sessionResult;
    }
}
