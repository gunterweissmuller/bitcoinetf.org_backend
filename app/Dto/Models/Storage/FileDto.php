<?php

declare(strict_types=1);

namespace App\Dto\Models\Storage;

use App\Dto\DtoInterface;

final class FileDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $path,
        private ?string $realPath,
        private ?string $type,
        private ?string $extension,
        private ?string $status,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['path'] ?? null,
            $args['real_path'] ?? null,
            $args['type'] ?? null,
            $args['extension'] ?? null,
            $args['status'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'path' => $this->path,
            'real_path' => $this->realPath,
            'type' => $this->type,
            'extension' => $this->extension,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param  string|null  $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param  string|null  $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string|null
     */
    public function getRealPath(): ?string
    {
        return $this->realPath;
    }

    /**
     * @param  string|null  $realPath
     */
    public function setRealPath(?string $realPath): void
    {
        $this->realPath = $realPath;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param  string|null  $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @param  string|null  $extension
     */
    public function setExtension(?string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param  string|null  $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param  string|null  $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param  string|null  $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
