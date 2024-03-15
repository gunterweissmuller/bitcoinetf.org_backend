<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Recovery;

use App\Dto\DtoInterface;
use App\Dto\Models\Users\EmailDto;

final class InitPipelineDto implements DtoInterface
{
    public function __construct(
        private ?EmailDto $email,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['email'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
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
}
