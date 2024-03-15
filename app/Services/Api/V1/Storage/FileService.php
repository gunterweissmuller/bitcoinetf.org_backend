<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Storage;

use App\Dto\Models\Storage\FileDto;
use App\Enums\Storage\File\StatusEnum;
use App\Enums\Storage\File\TypeEnum;
use App\Enums\Storage\S3\DirPathEnum;
use App\Repositories\Storage\File\FileRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

final class FileService
{
    private FileRepositoryInterface $repository;

    public function __construct(FileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(FileDto $dto): FileDto
    {
        $dto->setStatus($dto->getStatus() ?? StatusEnum::Dispatching->value);

        return $this->repository->create($dto);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update(array_filter($condition), $data);
    }

    public function get(array $filters, bool $originPath = false): ?FileDto
    {
        if ($originPath) {
            return $this->repository->get(array_filter($filters));
        }

        if ($row = $this->repository->get(array_filter($filters))) {
            $row->setPath(Storage::disk('s3')->url($row->getPath()));

            return $row;
        }

        return null;
    }

    public function list(array $filters, callable $callback = null): ?Collection
    {
        return $this->repository->list(array_filter($filters), $callback);
    }

    public function delete(array $filters): void
    {
        $this->repository->update(array_filter($filters), ['status' => StatusEnum::Deleting->value]);
    }

    public function count(array $filters): int
    {
        return $this->repository->count(array_filter($filters));
    }

    public function getAccess(string $type): string
    {
        return match ($type) {
            TypeEnum::Avatar->value => DirPathEnum::Public->value,
            default => DirPathEnum::Private->value,
        };
    }

    public function getS3DirPath(string $type, $public = false): string
    {
        $access = match ($type) {
            TypeEnum::Avatar->value => DirPathEnum::Public->value,
            default => DirPathEnum::Private->value,
        };

        if ($public) {
            $access = DirPathEnum::Public->value;
        }

        return $access.'/'.$type.Carbon::now()->format('/Y/m/d/H/i/').hash('sha256', (string) rand(10, 9999));
    }
}
