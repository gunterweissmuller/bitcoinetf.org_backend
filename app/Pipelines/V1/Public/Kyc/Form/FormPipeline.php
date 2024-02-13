<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Form;

use App\Dto\Pipelines\Api\V1\Public\Kyc\Form\GetPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Kyc\Form\Pipes\Get\FormPipe as GetFormPipe;

final class FormPipeline extends AbstractPipeline
{
    public function get(GetPipelineDto $dto): array
    {
        return $this->pipeline([
            GetFormPipe::class,
        ], $dto);
    }
}
