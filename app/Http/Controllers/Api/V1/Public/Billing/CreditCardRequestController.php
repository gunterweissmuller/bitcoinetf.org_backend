<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing;

use App\Dto\Models\Billing\CreditCardRequestDto;
use App\Enums\Billing\CreditCardRequest\StatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\EmptyRequest;
use App\Services\Api\V1\Billing\CreditCardRequestService;

final class CreditCardRequestController extends Controller
{
    public function __construct(private readonly CreditCardRequestService $service) {}

    public function create(EmptyRequest $request): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        $request = $this->service->get(['account_uuid' => $accountUuid]);

        if (!$request) {
            $request = $this->service->create(CreditCardRequestDto::fromArray([
                'account_uuid' => $accountUuid,
                'status' => StatusEnum::PENDING->value,
            ]));
        }

        return response()->json(['data' => $this->getInfo($request)]);
    }

    public function info(EmptyRequest $request): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        $request = $this->service->get(['account_uuid' => $accountUuid]);

        return response()->json(['data' => $this->getInfo($request)]);
    }

    private function getInfo(?CreditCardRequestDto $dto): array
    {
        return [
            'number' => $dto ? $this->service->number($dto->getCreatedAt())+7304 : 7304,
            'is_created' => (bool)$dto,
            'status' => $dto?->getStatus(),
            'count' => $this->service->total() + 7304,
            'created_at' => $dto?->getCreatedAt(),
        ];
    }
}
