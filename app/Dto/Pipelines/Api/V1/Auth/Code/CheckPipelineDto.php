<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Code;

use App\Dto\DtoInterface;
use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\EmailDto;

final class CheckPipelineDto implements DtoInterface
{
    public function __construct(
        private ?EmailDto $email,
        private ?CodeDto $code,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['email'] ?? null,
            $args['code'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'code' => $this->code,
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
}
