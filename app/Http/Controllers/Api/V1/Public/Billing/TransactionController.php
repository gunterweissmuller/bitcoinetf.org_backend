<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing;

use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Http\Requests\Api\EmptyRequest;
use App\Http\Requests\Api\V1\Public\Billing\Transaction\ListRequest;
use App\Models\Billing\Payment;
use App\Services\Api\V1\Billing\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class TransactionController extends Controller
{
    public function __construct(
        private readonly PaymentService $service
    ) {
    }

    public function all(ListRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $type = $dto->getFilters()['type'];

        $filters = match ($type) {
            WalletTypeEnum::VAULT->value => [
                'account_uuid' => $request->payload()->getUuid(),
                ['vault_amount', '!=', null],
            ],
            WalletTypeEnum::DIVIDENDS->value => [
                'account_uuid' => $request->payload()->getUuid(),
                ['dividend_amount', '!=', null],
            ],
            WalletTypeEnum::REFERRAL->value => [
                'account_uuid' => $request->payload()->getUuid(),
                ['referral_amount', '!=', null],
            ],
            WalletTypeEnum::BONUS->value => [
                'account_uuid' => $request->payload()->getUuid(),
                ['bonus_amount', '!=', null],
            ],
        };

        $dto->setFilters($filters);

        $rows = $this->service->allByFilters($dto);

        $rows->through(function (Payment $value) use ($type) {
            $usdAmount = match ($type) {
                WalletTypeEnum::VAULT->value => $value->vault_amount,
                WalletTypeEnum::DIVIDENDS->value => $value->dividend_amount,
                WalletTypeEnum::REFERRAL->value => $value->referral_amount,
                WalletTypeEnum::BONUS->value => $value->bonus_amount,
            };

            $btcAmount = (1 / $value->btc_price) * $usdAmount;

            return [
                'uuid' => $value->uuid,
                'type' => $value->type,
                'usd_amount' => $usdAmount ? number_format($usdAmount, 8, '.', '') : 0,
                'btc_amount' => ($btcAmount && $btcAmount > 0) ? number_format($btcAmount, 8, '.', '') : $btcAmount,
                'desc_type' => $value->desc_type,
                'withdrawal_method' => $value->withdrawal_method,
                'created_at' => $value->payday ? $value->payday : $value->created_at,
            ];
        });

        return response()->json(['data' => $rows]);
    }

    public function get(EmptyRequest $request, string $uuid): JsonResponse
    {
        return response()->json([
            'data' => $this->service->get([
                'uuid' => $uuid,
                'account_uuid' => $request->payload()->getUuid(),
            ])?->toArray(),
        ]);
    }
}
