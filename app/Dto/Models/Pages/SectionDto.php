<?php

declare(strict_types=1);

namespace App\Dto\Models\Pages;

use App\Dto\DtoInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

final class SectionDto implements DtoInterface
{
    public function __construct(
        private int|null $id,
        private int|null $pageId,
        private int|null $languageId,
        private string|null $name,
        private string|null $status,
        private int|null $number,
        private array|null $data,
        private array|null $files,
        private string|null $createdAt,
        private string|null $updatedAt
    )
    {
    }

    public static function fromArray(array $arguments): DtoInterface|self
    {
        return new self(
            $arguments['id'] ?? null,
            $arguments['page_id'] ?? null,
            $arguments['language_id'] ?? null,
            $arguments['name'] ?? null,
            $arguments['status'] ?? null,
            $arguments['number'] ?? null,
            $arguments['data'] ?? null,
            $arguments['files'] ?? null,
            $arguments['created_at'] ?? null,
            $arguments['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'page_id' => $this->pageId,
            'language_id' => $this->languageId,
            'name' => $this->name,
            'status' => $this->status,
            'number' => $this->number,
            'data' => $this->data,
            'files' => $this->filesToArray($this->files),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    private function filesToArray(?array $files = []): ?array
    {
        if ($files) {
            $newFiles = [];
            foreach($files as $file) {
                $file['real_path'] = Storage::disk('s3')->temporaryUrl(
                    $file['path'], Carbon::now()->addMinutes(5)
                );
                $newFiles[] = $file;
            }

            return $newFiles;
        }

        return $files;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPageId(): ?int
    {
        return $this->pageId;
    }

    public function setPageId(?int $pageId): void
    {
        $this->pageId = $pageId;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getLanguageId(): ?int
    {
        return $this->languageId;
    }
}
