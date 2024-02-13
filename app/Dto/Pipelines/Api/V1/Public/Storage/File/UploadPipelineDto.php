<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Storage\File;

use App\Dto\DtoInterface;
use App\Dto\Models\Storage\FileDto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadPipelineDto implements DtoInterface
{
    public function __construct(
        private ?UploadedFile $uploadedFile,
        private ?FileDto $file
    ) {
    }


    public function toArray(): array
    {
        return [
            'file_dto' => $this->file,
            'uploaded_file' => $this->uploadedFile,
        ];
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['file'],
            $args['uploaded_file']
        );
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }

    /**
     * @param  UploadedFile  $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * @return FileDto
     */
    public function getFile(): FileDto
    {
        return $this->file;
    }

    /**
     * @param  FileDto  $file
     */
    public function setFile(FileDto $file): void
    {
        $this->file = $file;
    }
}
