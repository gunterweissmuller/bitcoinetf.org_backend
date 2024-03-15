<?php

declare(strict_types=1);

namespace App\Pipelines;

use App\Dto\DtoInterface;
use Closure;

interface PipeInterface
{
    public function handle(DtoInterface $dto, Closure $next): DtoInterface;
}
