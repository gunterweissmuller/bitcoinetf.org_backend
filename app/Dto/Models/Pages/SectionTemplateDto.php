<?php

declare(strict_types=1);

namespace App\Dto\Models\Pages;

use App\Dto\DtoInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

final class SectionTemplateDto implements DtoInterface
{
    public function __construct(
        private int|null $id,
        private string|null $name,
        private string|null $symbol,
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
            $arguments['name'] ?? null,
            $arguments['symbol'] ?? null,
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
            'name' => $this->name,
            'symbol' => $this->symbol,
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

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
