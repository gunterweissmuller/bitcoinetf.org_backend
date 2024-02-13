<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\News\Article\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Enums\Storage\File\StatusEnum as FileStatusesEnum;
use App\Exceptions\Core\NotFoundException as FilesExistsException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Storage\FileService;
use Closure;
use Illuminate\Support\Facades\Storage;

final class FilesPipe implements PipeInterface
{
    private FileService $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function handle(DtoInterface|ArticlePipelineDto $dto, Closure $next): DtoInterface
    {
        $dto->setPreviewFileUuid(
            $this->getCheckAndUuid($dto->getPreviewFileUuid()),
        );
        $dto->setMainFileUuid(
            $this->getCheckAndUuid($dto->getMainFileUuid()),
        );

        return $next($dto);
    }

    private function getCheckAndUuid(?string $fileUuid): ?string
    {
        if ($fileUuid) {
            $file = $this->service->get([
                'uuid' => $fileUuid,
                'status' => FileStatusesEnum::Active->value,
            ], true);

            if (str_contains($file->getPath(), 'private')) {
                $extension = pathinfo($file->getPath(), PATHINFO_EXTENSION);
                $directory = $this->service->getS3DirPath('image', true);
                $newPath = $directory.'.'.$extension;

                $fileData = Storage::disk('s3')->get($file->getPath());
                if (Storage::disk('s3')->put($newPath, $fileData)) {
                    Storage::disk('s3')->delete($file->getPath());

                    $file->setPath($newPath);
                    $file->setRealPath(Storage::disk('s3')->url($newPath));

                    $this->service->update([
                        'uuid' => $fileUuid,
                    ], [
                        'path' => $file->getPath(),
                        'real_path' => $file->getRealPath(),
                    ]);
                }
//                if (Storage::disk('s3')->move($file->getPath(), $newPath)) {
//                    Storage::disk('s3')->delete($file->getPath());
//
//                    $file->setPath($newPath);
//                    $file->setRealPath(Storage::disk('s3')->url($newPath));
//
//                    $this->service->update([
//                        'uuid' => $fileUuid,
//                    ], [
//                        'path' => $file->getPath(),
//                        'real_path' => $file->getRealPath(),
//                    ]);
//                }
            }

            if (is_null($file)) {
                throw new FilesExistsException();
            }

            return $file->getUuid();
        }

        return null;
    }
}
