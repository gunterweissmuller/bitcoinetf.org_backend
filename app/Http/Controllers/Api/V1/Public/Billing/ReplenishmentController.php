<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing;

use App\Enums\Billing\Replenishment\StatusEnum;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotFoundException;
use App\Http\Requests\Api\EmptyRequest;
use App\Services\Api\V1\Billing\ReplenishmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class ReplenishmentController extends Controller
{
    public function __construct(
        private readonly ReplenishmentService $replenishmentService,
    ) {
    }

    public function get(string $uuid, EmptyRequest $request): JsonResponse
    {
        if ($row = $this->replenishmentService->get([
            'uuid' => $uuid,
            'account_uuid' => $request->payload()->getUuid(),
        ], function ($query) {
            return $query->whereIn('status', [StatusEnum::INIT->value, StatusEnum::PENDING->value])
                ->orderBy('created_at', 'desc');
        })) {
            return response()->json([
                'data' => [
                    ...$row->toArray(),
                    'redirect_uri' => $row->getMerchant001Id() ? 'https://app.merchant001.io/payment/'.$row->getMerchant001Id() : null,
                ]
            ]);
        } else {
            throw new ReplenishmentNotFoundException();
        }
    }

    public function last(EmptyRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->replenishmentService->get([
                'account_uuid' => $request->payload()->getUuid(),
            ], function ($query) {
                return $query->whereIn('status', [StatusEnum::INIT->value, StatusEnum::PENDING->value])
                    ->orderBy('created_at', 'desc');
            })?->toArray(),
        ]);
    }
}
