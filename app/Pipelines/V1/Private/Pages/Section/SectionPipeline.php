<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\Section;

use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Private\Pages\Section\Pipes\FilesPipe;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Create\SectionPipe as CreateSectionPipe;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Update\SectionPipe as UpdateSectionPipe;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Delete\SectionPipe as DeleteSectionPipe;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Create\SectionFilePipe as CreateSectionFilePipe;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Update\SectionFilePipe as UpdateSectionFilePipe;
use App\Pipelines\V1\Private\Pages\Section\Pipes\Delete\SectionFilePipe as DeleteSectionFilePipe;

final class SectionPipeline extends AbstractPipeline
{
    public function create(SectionPipelineDto $dto): array
    {
        return $this->pipeline([
            FilesPipe::class,
            CreateSectionPipe::class,
            CreateSectionFilePipe::class,
        ], $dto);
    }

    public function update(SectionPipelineDto $dto): array
    {
        return $this->pipeline([
            FilesPipe::class,
            UpdateSectionPipe::class,
            UpdateSectionFilePipe::class,
        ], $dto);
    }

    public function delete(SectionPipelineDto $dto): array
    {
        return $this->pipeline([
            DeleteSectionPipe::class,
            DeleteSectionFilePipe::class,
        ], $dto);
    }
}
