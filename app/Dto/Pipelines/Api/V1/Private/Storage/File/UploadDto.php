<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Private\Storage\File;

use App\Dto\DtoInterface;
use App\Dto\Models\Storage\FileDto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadDto implements DtoInterface
{
    private UploadedFile $uploadedFile;

    private FileDto $fileDto;

    public function __construct(UploadedFile $uploadedFile, FileDto $fileDto)
    {
        $this->uploadedFile = $uploadedFile;
        $this->fileDto = $fileDto;
    }


    public function toArray(): array
    {
        return [
            'file_dto' => $this->fileDto,
            'uploaded_file' => $this->uploadedFile,
        ];
    }

    public static function fromArray(array $arguments): DtoInterface|UploadDto
    {
        return new self(
            $arguments['file_dto'],
            $arguments['uploaded_file']
        );
    }

    public function getFile(): FileDto
    {
        return $this->fileDto;
    }

    public function setFile(FileDto $fileDto): void
    {
        $this->fileDto = $fileDto;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}
