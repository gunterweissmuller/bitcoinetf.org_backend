<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing;

use App\Enums\Billing\Wallet\WithdrawalMethodEnum;
use App\Http\Requests\Api\V1\Public\Billing\Withdrawal\DividendRequest;
use App\Http\Requests\Api\V1\Public\Billing\Withdrawal\ListRequest;
use App\Http\Requests\Api\V1\Public\Billing\Withdrawal\MethodRequest;
use App\Http\Requests\Api\V1\Public\Billing\Withdrawal\ReferralCallbackRequest;
use App\Http\Requests\Api\V1\Public\Billing\Withdrawal\ReferralRequest;
use App\Pipelines\V1\Public\Billing\Withdrawal\WithdrawalPipeline;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Billing\WithdrawalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class WithdrawalController extends Controller
{
    public function __construct(
        private readonly WithdrawalPipeline $pipeline,
        private readonly WalletService $walletService,
        private readonly WithdrawalService $withdrawalService,
    ) {
    }

    public function list(ListRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->withdrawalService->allByFilters($request->dto()),
        ]);
    }

    /**
     * @param MethodRequest $request
     * @return JsonResponse
     */
    public function method(MethodRequest $request): JsonResponse
    {
        $dto = $request->dto();

        if ($dto->getWithdrawalMethod() == WithdrawalMethodEnum::NONE->value) {
            $dto->setWithdrawalAddress(null);
        }

        $this->walletService->update([
            'account_uuid' => $dto->getAccountUuid(),
            'type' => $dto->getType(),
        ], [
            'withdrawal_address' => $dto->getWithdrawalAddress(),
            'withdrawal_method' => $dto->getWithdrawalMethod(),
        ]);

        return response()->json();
    }

    public function dividends(DividendRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->dividends($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    public function referrals(ReferralRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->referrals($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    public function dividendsCallback(): JsonResponse
    {
        return response()->json();
    }

    public function referralsCallback(ReferralCallbackRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->referralsCallback($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
