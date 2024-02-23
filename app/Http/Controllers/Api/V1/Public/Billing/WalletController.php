<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing;

use App\Dto\Models\Billing\WalletDto;
use App\Enums\Billing\Payment\TypeEnum as PaymentTypeEnum;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Http\Requests\Api\EmptyRequest;
use App\Models\Billing\Payment;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

final class WalletController extends Controller
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly PaymentService $paymentService,
        private readonly TokenService $tokenService,
    ) {
    }

    public function all(EmptyRequest $request): JsonResponse
    {
        $output = [];

        $wallets = $this->walletService->all(['account_uuid' => $request->payload()->getUuid()]);

        /** @var WalletDto $wallet */
        foreach ($wallets as $wallet) {
            $output[$wallet->getType()] = $this->getWalletOutput($wallet);
        }

        return response()->json([
            'data' => $output,
        ]);
    }

    public function get(EmptyRequest $request, string $type): JsonResponse
    {
        $wallet = $this->walletService->get([
            'account_uuid' => $request->payload()->getUuid(),
            'type' => $type,
        ]);

        return response()->json([
            'data' => $this->getWalletOutput($wallet),
        ]);
    }

    private function getWalletOutput(?WalletDto $wallet): array
    {
        if (!$wallet) {
            return [];
        }

        $data = [
            'uuid' => $wallet->getUuid(),
            'withdrawal_method' => $wallet->getWithdrawalMethod(),
            'withdrawal_address' => $wallet->getWithdrawalAddress(),
            'usd_amount' => $wallet->getAmount(),
        ];

        if ($wallet->getType() == TypeEnum::VAULT->value) {
            $sumPayments = $this->paymentService->getSumPayments($wallet->getAccountUuid());

            $btcAmount = 0;
            $difference = 0;
            if ($wallet->getAmount() > 0) {
                $btcAmount = 1 / $this->tokenService->getBitcoinAmount() * $wallet->getAmount();

                if ($sumPayments > 0) {
                    $difference = ((($sumPayments + $wallet->getAmount()) - $sumPayments) / $sumPayments) * 100;
                }
            }

            $data = [
                ...$data,
                'btc_amount' => number_format($btcAmount, 8, '.', ''),
                'difference' => $difference,
            ];
        }

        if ($wallet->getType() == TypeEnum::DIVIDENDS->value) {
            $btcAmount = $wallet->getBtcAmount();
            $difference = 0;
            $btcAmountAdded = '0';
            $lastPayment = null;

            $sumToClient = Payment::query()
                ->select(DB::raw('sum(total_amount_btc)'))
                ->where([
                    'account_uuid' => $wallet->getAccountUuid(),
                    'type' => PaymentTypeEnum::DEBIT_TO_CLIENT->value,
                    ['dividend_wallet_uuid', '!=', null]
                ])
                ->first();

            $withdrawal = Payment::query()
                ->select(DB::raw('sum(total_amount_btc)'))
                ->where([
                    'account_uuid' => $wallet->getAccountUuid(),
                    'type' => PaymentTypeEnum::WITHDRAWAL->value,
                    ['dividend_wallet_uuid', '!=', null]
                ])
                ->first();

            $reinvesting = Payment::query()
                ->select(DB::raw('sum(total_amount_btc)'))
                ->where([
                    'account_uuid' => $wallet->getAccountUuid(),
                    'type' => PaymentTypeEnum::CREDIT_FROM_CLIENT->value,
                    ['dividend_wallet_uuid', '!=', null]
                ])
                ->first();

            $btcAmountAdded = Payment::query()
                ->where([
                    'account_uuid' => $wallet->getAccountUuid(),
                    ['dividend_wallet_uuid', '!=', null],
                    'type' => PaymentTypeEnum::DEBIT_TO_CLIENT->value,
                ])
                ->sum('total_amount_btc');

            $lastPayment = Payment::query()
                ->where([
                    'account_uuid' => $wallet->getAccountUuid(),
                    ['dividend_wallet_uuid', '!=', null],
                    'type' => PaymentTypeEnum::DEBIT_TO_CLIENT->value,
                ])
                ->orderBy('created_at', 'DESC')
                ->first();

            if ($btcAmount > 0) {
                $difference = ((((float) $btcAmount + $lastPayment['total_amount_btc']) - (float) $btcAmount) / (float) $btcAmount) * 100;
            }

            $data = [
                ...$data,
                'usd_amount' => (float) bcmul(
                    number_format($btcAmount, 8, '.', ''),
                    number_format($this->tokenService->getBitcoinAmount(), 8, '.', ''),
                    8
                ),
                'btc_amount' => number_format((float)$wallet->getBtcAmount(), 8, '.', ''),
                'btc_amount_added' => number_format((float) $btcAmountAdded, 8, '.', ''),
                'difference' => $difference,
            ];
        }

        return $data;
    }
}
