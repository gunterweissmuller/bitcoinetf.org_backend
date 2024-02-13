<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Storage;

use App\Http\Requests\Api\V1\Public\Storage\File\UploadRequest;
use App\Pipelines\V1\Public\Storage\File\FilePipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class FileController extends Controller
{
    public function __construct(
        private readonly FilePipeline $pipeline,
    ) {
    }

    public function upload(UploadRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->upload($request->dto());

        if (!$e) {
            return response()->json([
                'data' => $dto->getFile()->toArray(),
            ]);
        }

        return response()->__call('exception', [$e]);
    }
}
