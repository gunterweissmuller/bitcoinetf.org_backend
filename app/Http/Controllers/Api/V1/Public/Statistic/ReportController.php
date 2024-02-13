<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Statistic;

use App\Enums\Statistic\Report\TypeEnum;
use App\Exceptions\Core\NotFoundException;
use App\Http\Requests\Api\EmptyRequest;
use App\Http\Requests\Api\V1\Public\Statistic\Report\ListRequest;
use App\Models\Statistic\Report;
use App\Services\Api\V1\Statistic\ReportService;
use App\Services\Api\V1\Storage\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ReportController extends Controller
{
    public function __construct(private ReportService $service)
    {
    }

    public function list(ListRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->setFilters([
            'type' => TypeEnum::MONTHLY_PAYMENTS_REPORT->value,
            'account_uuid' => $request->payload()->getUuid(),
        ]);
        $rows = $this->service->allByFilters($dto);

        $rows->through(function (Report $value) {
            $data = $value->toArray();
            $dateTime = Carbon::createFromDate($data['created_at']);

            return [
                'uuid' => $data['uuid'],
                'date' => $dateTime->format('F Y')
            ];
        });

        return response()->json(['data' => $rows]);
    }

    public function get(string $uuid, EmptyRequest $request, FileService $fileService): StreamedResponse
    {
        $report = $this->service->get([
            'uuid' => $uuid,
            'account_uuid' => $request->payload()->getUuid(),
        ]);

        if (!$report) {
            throw new NotFoundException();
        }

        $file = $fileService->get(['uuid' => $report->getFileUuid()], true);
        if (!$file) {
            throw new NotFoundException();
        }

        return Storage::disk('s3')->download($file->getPath());
    }
}
