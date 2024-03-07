<?php

declare(strict_types=1);

namespace App\Pipelines;

use App\Dto\DtoInterface;
use Exception;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class AbstractPipeline
{
    protected Pipeline $pipeline;

    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    protected function pipeline(array $pipes, DtoInterface $dto): array
    {
        $exception = false;

        try {
            DB::beginTransaction();

            $dto = $this->pipeline
                ->send($dto)
                ->through($pipes)
                ->then(function (DtoInterface $newDto) {
                    return $newDto;
                });

            DB::commit();
        } catch (Exception|Throwable $e) {
            DB::rollBack();
            Log::error((string) $e);
            dump($e->getMessage());
            $exception = $e;
        }

        return [$dto, $exception];
    }
}
