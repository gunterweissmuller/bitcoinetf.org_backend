<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Kyc;

use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\AllPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\GetPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Http\Requests\Api\V1\Public\Kyc\Screen\AllRequest;
use App\Http\Requests\Api\V1\Public\Kyc\Screen\GetRequest;
use App\Http\Requests\Api\V1\Public\Kyc\Screen\SaveRequest;
use App\Http\Requests\Api\V1\Public\Kyc\Screen\StateRequest;
use App\Pipelines\V1\Public\Kyc\Screen\ScreenPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

final class ScreenController extends Controller
{
    public function __construct(
        private readonly ScreenPipeline $pipeline,
    ) {
    }

    public function states(StateRequest $request): JsonResponse
    {
        $file = storage_path('/kyc/countries.json');
        $countries = collect(json_decode(file_get_contents($file), true));

        $output = [];
        if ($country = $countries->where('value', $request->dto()->getValue())->first()) {
            $output = $country['states'] ?? [];
        }

        return response()->json([
            'data' => $output,
        ]);
    }

    public function all(AllRequest $request): JsonResponse
    {
        /** @var AllPipelineDto $dto */
        [$dto, $e] = $this->pipeline->all($request->dto());

        if (!$e) {
            return response()->json([
                'data' => $dto->getOutput(),
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    public function get(GetRequest $request): JsonResponse
    {
        /** @var GetPipelineDto $dto */
        [$dto, $e] = $this->pipeline->get($request->dto());

        if (!$e) {
            return response()->json([
                'data' => $dto->getOutput(),
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    public function save(SaveRequest $request): JsonResponse
    {
        /** @var SavePipelineDto $dto */
        [$dto, $e] = $this->pipeline->save($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
