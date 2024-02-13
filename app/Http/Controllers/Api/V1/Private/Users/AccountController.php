<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Private\Users;

use App\Dto\Models\Users\AccountDto;
use App\Http\Requests\Api\V1\Private\Users\Account\AllRequest;
use App\Http\Requests\Api\V1\Private\Users\Account\CreateRequest;
use App\Http\Requests\Api\V1\Private\Users\Account\UpdateRequest;
use App\Models\Users\Account;
use App\Pipelines\V1\Private\Users\Account\AccountPipeline;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class AccountController extends Controller
{
    public function __construct(
        private readonly AccountService $service,
        private readonly AccountPipeline $pipeline,
    ) {
    }

    public function all(AllRequest $request): JsonResponse
    {
        $rows = $this->service->allByFilters($request->dto());

        $rows->through(function (Account $account) {
            $row = AccountDto::fromArray($account->toArray());

            return $this->getPayload($row);
        });

        return response()->json([
            'data' => $rows,
        ]);
    }

    public function get(string $uuid): JsonResponse
    {
        $row = $this->service->get(['uuid' => $uuid]);

        return response()->json([
            'data' => $row ? $this->getPayload($row) : null,
        ]);
    }

    public function create(CreateRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->create($request->dto());

        if (!$e) {
            return response()->json([
                'data' => $this->getPayload($dto->getAccount()),
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    public function update(UpdateRequest $request, string $uuid): JsonResponse
    {
        $this->service->update([
            'uuid' => $uuid,
        ], array_filter($request->dto()->toArray()));

        return response()->json();
    }

    public function delete(string $uuid): JsonResponse
    {
        $this->service->delete(['uuid' => $uuid]);

        return response()->json();
    }

    private function getPayload(AccountDto $dto): array
    {
        return [
            'uuid' => $dto->getUuid(),
            'number' => $dto->getNumber(),
            'username' => $dto->getUsername(),
            'type' => $dto->getType(),
            'status' => $dto->getStatus(),
            'personal_bonus' => $dto->getPersonalBonus(),
            'created_at' => $dto->getCreatedAt(),
            'updated_at' => $dto->getUpdatedAt(),
        ];
    }
}
