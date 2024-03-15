<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\SectionTemplate;

use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\FilesPipe;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;
use App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Create\SectionPipe as CreateSectionPipe;
use App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Update\SectionPipe as UpdateSectionPipe;
use App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Delete\SectionPipe as DeleteSectionPipe;
use App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Create\SectionFilePipe as CreateSectionFilePipe;
use App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Update\SectionFilePipe as UpdateSectionFilePipe;
use App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Delete\SectionFilePipe as DeleteSectionFilePipe;

final class SectionPipeline extends AbstractPipeline
{
    public function create(SectionTemplatePipelineDto $dto): array
    {
        return $this->pipeline([
            FilesPipe::class,
            CreateSectionPipe::class,
            CreateSectionFilePipe::class,
        ], $dto);
    }

    public function update(SectionTemplatePipelineDto $dto): array
    {
        return $this->pipeline([
            FilesPipe::class,
            UpdateSectionPipe::class,
            UpdateSectionFilePipe::class,
        ], $dto);
    }

    public function delete(SectionTemplatePipelineDto $dto): array
    {
        return $this->pipeline([
            DeleteSectionPipe::class,
            DeleteSectionFilePipe::class,
        ], $dto);
    }
}
