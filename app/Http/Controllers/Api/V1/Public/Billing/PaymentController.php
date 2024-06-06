<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing;

use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Settings\Global\SymbolEnum;
use App\Http\Requests\Api\EmptyRequest;
use App\Http\Requests\Api\V1\Public\Billing\Payment\ListRequest;
use App\Models\Billing\Payment;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Referrals\InviteService;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Services\Api\V1\Referrals\CodeService;
use App\Models\Referrals\Invite;
use App\Services\Api\V1\Billing\WalletService;

final class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $service
    ) {
    }

    public function last(
        EmptyRequest $request,
        TokenService $tokenService,
    ): JsonResponse {
        $accountUuid = $request->payload()->getUuid();
        $lastUserPayment = $this->service->getLastUserPayment($accountUuid);
        $sumUserPayments = $this->service->getSumPayments($accountUuid);
        $sumUserSells = $this->service->getSumPayments($accountUuid, TypeEnum::SELL->value);

        $result = [];
        if ($lastUserPayment) {
            $result = [
                'total_balance_usd' => $sumUserPayments - $sumUserSells,
                'btc_price' => $tokenService->getBitcoinAmount(),
                'created_at' => $lastUserPayment?->getCreatedAt(),
            ];
        }

        return response()->json([
            'data' => $result,
        ]);
    }

    public function statistic(
        EmptyRequest $request,
        GlobalService $globalService,
        TokenService $tokenService,
        AccountService $accountService,
        InviteService $inviteService,
    ): JsonResponse {
        $accountUuid = $request->payload()->getUuid();
        $sumPayments = $this->service->getSumPayments($accountUuid);
        $data = $this->service->getLastUserPayment($request->payload()->getUuid())?->toArray();
        $btcPrice = $tokenService->getBitcoinAmount();
        $btcInOneUsd = 1 / $tokenService->getBitcoinAmount();
        if (!is_null($data)) {
            $btcInOneUsd = 1 / $data['btc_price'];
        }
        $projectedApy = $globalService->get(['symbol' => SymbolEnum::PROJECTED_APY->value])->getValue();
        $amountLastDividend = $this->service->getLastDividend($accountUuid);
        $lastPayment = $this->service->getLastUserPayment($accountUuid);
        $lastPaymentWithThreeYears = $lastPayment
            ? Carbon::createFromDate($lastPayment->getCreatedAt())->addYears(3)->format('d M y')
            : 0;

        $isAccountHalfYear = $accountService->isAccountHalfYear($accountUuid);
        $isInvite = $inviteService->isInvite($accountUuid);
        $minApy = $globalService->getMinimumApyValue($isAccountHalfYear && $isInvite);

        $actualDividends = $this->service->getGroupingSumByMonth($accountUuid);
        foreach ($actualDividends as $actualDividend) {
            $actualDividend->sum = $actualDividend->sum ?? 0;
        }

        $buyPayments = $this->service->all([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
        ]);

        $dividends = [];
        if ($buyPayments) {
            foreach ($buyPayments as $i => $buyPayment) {
                $periodTo = ($i == 0)
                    ? Carbon::now()->toDateTimeString()
                    : Carbon::parse($buyPayments[$i - 1]->getCreatedAt())->toDateTimeString();
                $periodFrom = Carbon::parse($buyPayment->getCreatedAt())->toDateTimeString();

                $dividendsDays = Payment::query()
                    ->where([
                        'type' => TypeEnum::DEBIT_TO_CLIENT->value,
                        'account_uuid' => $accountUuid,
                        ['dividend_wallet_uuid', '!=', null],
                        ['created_at', '>=', $periodFrom],
                        ['created_at', '<=', $periodTo],
                    ])
                    ->count();

                if ($dividendsDays > 0) {
                    $amountBtc = (float) Payment::query()
                        ->where([
                            'account_uuid' => $accountUuid,
                            'type' => 'debit_to_client',
                            ['created_at', '>=', $periodFrom],
                            ['created_at', '<=', $periodTo],
                            ['dividend_wallet_uuid', '!=', null],
                        ])->sum('total_amount_btc');
                    $amountBuyUsd = $buyPayment->getTotalAmount();

                    $dividends[] = round(((($amountBtc * $btcPrice) * $minApy) / ((($amountBuyUsd * ($minApy / 100)) / 365) * $dividendsDays)),
                        2);
                }
            }
        }

        if (count($dividends)) {
            $actualApy = array_sum($dividends) / count($dividends);
            $actualApy = ($actualApy > $minApy) ? $actualApy : $minApy;
        } else {
            $actualApy = 0;
        }

//        $actualApy = 0;
//        if ($sumDividendsBtc && $guaranteedUsd) {
//            $days = Payment::query()
//                ->where([
//                    'type' => 'debit_to_client',
//                    'account_uuid' => $accountUuid,
//                    ['dividend_wallet_uuid', '!=', null],
//                ])
//                ->count('uuid');
//
//            if ($days > 0) {
//                $actualApy = round(((($sumDividendsBtc * $btcPrice) * $minApy) / ((($sumUserPayments * ($minApy / 100)) / 365) * $days)),
//                    2);
//            }
//        }

        $isAccountHalfYear = $accountService->isAccountHalfYear($accountUuid);
        $isInvite = $inviteService->isInvite($accountUuid);

        $amountLastDividendUsd = $amountLastDividend?->getDividendAmount()
            ? (float) number_format($amountLastDividend->getDividendAmount(), 8, '.', '')
            : 0;

        $amountLastDividendBtc = $amountLastDividend?->getDividendAmount()
            ? (float) bcmul(
                number_format($amountLastDividend->getDividendAmount(), 8, '.', ''),
                number_format($btcInOneUsd, 8, '.', '')
            )
            : 0;

        return response()->json([
            'data' => [
                'dividends' => [
                    'last_payment_with_three_years' => $lastPaymentWithThreeYears,
                    'actual_apy' => $actualApy,
                    'actual_dividends' => $actualDividends->slice(0, 6),
                    'projected_apy' => $globalService->get(['symbol' => SymbolEnum::PROJECTED_APY->value])->getValue(),
                    'minimum_apy' => $globalService->getMinimumApyValue($isAccountHalfYear && $isInvite),
                ],
                'statistic' => [
                    'projected_total_dividends_usd' => $data ? ($sumPayments * ($projectedApy / 100) * 3) : 0,
                    'projected_total_dividends_btc' => $data ? ($sumPayments * $btcInOneUsd * ($projectedApy / 100) * 3) : 0,
                    'received_dividends_usd' => (float) number_format($this->service->getTotalDividends($accountUuid),
                        8, '.', ''),
                    'received_dividends_btc' => number_format($this->service->getTotalDividendsBtc($accountUuid), 8,
                        '.', ''),
                    'amount_last_dividend_usd' => $amountLastDividendUsd,
                    'amount_last_dividend_btc' => $amountLastDividendBtc,
                    'btc_price' => $btcPrice,
                ],
            ]
        ]);
    }

    public function personalDividends(ListRequest $request): JsonResponse
    {
        $dto = $request->dto();
        $dto->setFilters([
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            'account_uuid' => $request->payload()->getUuid(),
            ['dividend_amount', '!=', null],
            ['dividend_wallet_uuid', '!=', null],
            'referral_wallet_uuid' => null,
            'bonus_wallet_uuid' => null,
        ]);

        $rows = $this->service->allByFilters($dto);

        $rows->through(function (Payment $value) {
            $data = $value->toArray();
            $dateTime = Carbon::createFromDate($data['created_at']);

            $data['date_string'] = $dateTime->format('d M Y');
            $data['time'] = $dateTime->format('H:i');

            return $data;
        });

        return response()->json(['data' => $rows]);
    }

    public function personalShares(ListRequest $request, WalletService $serviceWallet): JsonResponse
    {
        $dto = $request->dto();
        $dto->setFilters([
            'account_uuid' => $request->payload()->getUuid(),
            ['real_amount', '!=', null],
            ['type', '!=', TypeEnum::DEBIT_TO_CLIENT->value],
            ['type', '!=', TypeEnum::WITHDRAWAL->value],
        ]);

        $bonusWalletBalance = $serviceWallet->getUserBonusBalance($request->payload()->getUuid());

        $rows = $this->service->allByFilters($dto);

        $rows->through(function (Payment $value) {
            $data = $value->toArray();
            $dateTime = Carbon::createFromDate($data['created_at']);
            $data['date_string'] = $dateTime->format('d M Y');
            $data['time'] = $dateTime->format('H:i');
            $keys = ['type', 'real_amount', 'referral_amount', 'bonus_amount', 'dividend_amount', 'date_string', 'time'];
            $result = array_filter(
                $data,
                function ($key) use ($keys) {
                    return in_array($key, $keys);
                },
                ARRAY_FILTER_USE_KEY
            );
            return $result;
        });

        return response()->json([
            'data' => $rows,
            'bonus_wallet' => $bonusWalletBalance
            ]);
    }

    public function personalDividendsByPeriod(ListRequest $request): JsonResponse
    {
        $dividendsOldest = Cache::rememberForever('dividendsOldest', function () {
            return Payment::query()
                ->where([
                    'type' => TypeEnum::DEBIT_TO_CLIENT->value,
                    ['dividend_wallet_uuid', '!=', null],
                ])
                ->oldest('created_at')->first();
        });
        $maxDays = $dividendsOldest['created_at']->diffInDays(now());
        $filterDays =  (int) $request->get('days');
        if ($filterDays > 0 && $filterDays <= $maxDays) {
            $sumDividends = $this->service->getTotalDividendsInPeriod(
                now()->subDays($filterDays)->startOfDay()->toDateTimeString(),
                now()->toDateTimeString(),
                $request->payload()->getUuid()
            );
            $sumDividendsBtc = $this->service->getTotalDividendsBtcInPeriod(
            now()->subDays($filterDays)->startOfDay()->toDateTimeString(),
            now()->toDateTimeString(),
                $request->payload()->getUuid()
            );
            $fromDaysAgo = $filterDays;
        } else {
            $sumDividends = $this->service->getTotalDividendsInPeriod(
                now()->subDays($maxDays + 1)->startOfDay()->toDateTimeString(),
                now()->toDateTimeString(),
                $request->payload()->getUuid()
            );
            $sumDividendsBtc = $this->service->getTotalDividendsBtcInPeriod(
                now()->subDays($maxDays + 1)->startOfDay()->toDateTimeString(),
                now()->toDateTimeString(),
                $request->payload()->getUuid()
            );
            $fromDaysAgo = $maxDays + 1;
        }

        return response()->json([
            'data' => [
                'sum_dividends' => $sumDividends,
                'sum_dividends_btc' => $sumDividendsBtc,
                'from_days_ago' => $fromDaysAgo,
            ]
        ]);
    }

    public function personalReferralsByPeriod(ListRequest $request, CodeService $codeService): JsonResponse
    {
        $invitedInvestorsCount = 0;
        $acceptedInvitation = 0;
        $code = $codeService->get(['account_uuid' => $request->payload()->getUuid()]);
        if ($code) {
            $invitedInvestors = Invite::query()->where([['code_uuid','=',$code->getUuid()]])->get();
            $invitedInvestorsCount = $invitedInvestors->count();
            foreach ($invitedInvestors as $investor) {
                $hasPayment = $this->service->getLastUserPayment($investor->account_uuid);
                if ($hasPayment) {
                    $acceptedInvitation++;
                }
            }
        }
        $referralsOldest = Cache::rememberForever('referralsOldest', function () {
            return Payment::query()
                ->where([
                    'type' => TypeEnum::DEBIT_TO_CLIENT->value,
                    ['referral_amount', '>', 0],
                ])
                ->oldest('created_at')->first();
        });
        $maxDays = $referralsOldest['created_at']->diffInDays(now());
        $filterDays =  (int) $request->get('days');
        if ($filterDays > 0 && $filterDays <= $maxDays) {
            $sumReferrals = $this->service->getSumColumnByPeriod(
                'referral_amount',
                $request->payload()->getUuid(),
                now()->subDays($filterDays)->startOfDay()->toDateTimeString(),
                now()->toDateTimeString(),
            );
            $fromDaysAgo = $filterDays;
        } else {
            $sumReferrals = $this->service->getSumColumnByPeriod(
                'referral_amount',
                $request->payload()->getUuid(),
                now()->subDays($maxDays + 1)->startOfDay()->toDateTimeString(),
                now()->toDateTimeString(),
            );
            $fromDaysAgo = $maxDays + 1;
        }

        return response()->json([
            'data' => [
                'sum_referrals' => $sumReferrals,
                'from_days_ago' => $fromDaysAgo,
                'invited_investors' => $invitedInvestorsCount,
                'accepted_invitation' => $acceptedInvitation,
            ]
        ]);
    }
}
