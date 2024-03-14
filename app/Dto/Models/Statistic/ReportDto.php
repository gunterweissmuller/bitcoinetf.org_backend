<?php

declare(strict_types=1);

namespace App\Dto\Models\Statistic;

use App\Dto\DtoInterface;

final class ReportDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $fileUuid,
        private ?string $type,
        private ?string $createdAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['file_uuid'] ?? null,
            $args['type'] ?? null,
            $args['created_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'file_uuid' => $this->fileUuid,
            'type' => $this->type,
            'created_at' => $this->createdAt,
        ];
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    public function getFileUuid(): ?string
    {
        return $this->fileUuid;
    }

    public function setFileUuid(?string $fileUuid): void
    {
        $this->fileUuid = $fileUuid;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
