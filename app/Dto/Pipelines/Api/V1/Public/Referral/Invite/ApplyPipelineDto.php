<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Referral\Invite;

use App\Dto\DtoInterface;
use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Referrals\InviteDto;

final class ApplyPipelineDto implements DtoInterface
{
    public function __construct(
        private ?CodeDto $code,
        private ?InviteDto $invite,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['code'] ?? null,
            $args['invite'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'invite' => $this->invite,
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
     * @return InviteDto|null
     */
    public function getInvite(): ?InviteDto
    {
        return $this->invite;
    }

    /**
     * @param  InviteDto|null  $invite
     */
    public function setInvite(?InviteDto $invite): void
    {
        $this->invite = $invite;
    }
}
