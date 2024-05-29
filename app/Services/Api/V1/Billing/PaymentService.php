<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Billing;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Billing\PaymentDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Repositories\Billing\Payment\PaymentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PaymentService
{
    public function __construct(private readonly PaymentRepositoryInterface $repository)
    {
    }

    public function create(PaymentDto $dto): PaymentDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?PaymentDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function all(array $filters): ?Collection
    {
        return $this->repository->all($filters);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }

    public function getTotalDividends(?string $accountUuid = null): float
    {
        if ($accountUuid) {
            return $this->repository->getSum('dividend_amount', [
                'account_uuid' => $accountUuid,
                'type' => TypeEnum::DEBIT_TO_CLIENT->value,
                ['dividend_amount', '!=', null],
            ]);
        }

        return $this->repository->getSum('dividend_amount', [
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ['dividend_amount', '!=', null],
        ]);
    }


    public function getTotalDividendsInPeriod(string $from, string $to, ?string $accountUuid = null): float
    {
        if ($accountUuid) {
            return $this->repository->getSumInPeriod('dividend_amount', [
                'account_uuid' => $accountUuid,
                'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ], $from, $to);
        }

        return $this->repository->getSumInPeriod('dividend_amount', [
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
        ], $from, $to);
    }

    public function getTotalDividendsBtc(?string $accountUuid = null, ?array $filter = []): float
    {
        if ($accountUuid) {
            return $this->repository->getSum('total_amount_btc', array_merge([
                'account_uuid' => $accountUuid,
                'type' => TypeEnum::DEBIT_TO_CLIENT->value,
                ['dividend_amount', '!=', null],
            ], $filter));
        }

        return $this->repository->getSum('total_amount_btc', array_merge([
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ['dividend_amount', '!=', null],
        ], $filter));
    }

    public function getTotalDividendsBtcInPeriod(string $from, string $to, ?string $accountUuid = null): float
    {
        if ($accountUuid) {
            return $this->repository->getSumInPeriod('total_amount_btc', [
                'account_uuid' => $accountUuid,
                'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ], $from, $to);
        }

        return $this->repository->getSumInPeriod('total_amount_btc', [
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
        ], $from, $to);
    }

    public function getSumColumnByPeriod(
        string $column,
        string $accountUuid,
        string $periodFrom,
        string $periodTo,
        string $type = null,
    ): float {
        $type = $type ?? TypeEnum::DEBIT_TO_CLIENT->value;

        return $this->repository->getSum($column, [
            'account_uuid' => $accountUuid,
            'type' => $type,
            ['created_at', '>=', $periodFrom],
            ['created_at', '<=', $periodTo]
        ]);
    }

    public function getSumPayments(string $accountUuid, string $type = null): float
    {
        $type = $type ?? TypeEnum::CREDIT_FROM_CLIENT->value;

        $referralAmount = $this->repository->getSum('referral_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
        ]);

        $bonusAmount = $this->repository->getSum('bonus_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
        ]);

        $dividendAmount = $this->repository->getSum('dividend_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
        ]);

        $realAmount = $this->repository->getSum('real_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
        ]);

        return ($referralAmount + $bonusAmount + $dividendAmount + $realAmount);
    }

    public function getLastDividend(string $accountUuid): ?PaymentDto
    {
        return $this->repository->getLastPayment(PaymentDto::fromArray([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ['dividend_amount', '!=', null],
        ]));
    }

    public function getLastUserPayment(string $accountUuid): ?PaymentDto
    {
        return $this->repository->getLastPayment(PaymentDto::fromArray([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
        ]));
    }

    public function getGroupingSumByMonth(string $accountUuid, int $limit = 6): ?Collection
    {
        return $this->repository->getGroupingSumByMonth([
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            ['dividend_wallet_uuid', '!=', null]
        ], $limit);
    }

    public function getSumPaymentsByPeriod(string $accountUuid, string $to, string $type = null): float
    {
        $type = $type ?? TypeEnum::CREDIT_FROM_CLIENT->value;

        $referralAmount = $this->repository->getSum('referral_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
            ['created_at', '<=', $to],
        ]);

        $bonusAmount = $this->repository->getSum('bonus_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
            ['created_at', '<=', $to],
        ]);

        $dividendAmount = $this->repository->getSum('dividend_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
            ['created_at', '<=', $to],
        ]);

        $realAmount = $this->repository->getSum('real_amount', [
            'account_uuid' => $accountUuid,
            'type' => $type,
            ['created_at', '<=', $to],
        ]);

        return ($referralAmount + $bonusAmount + $dividendAmount + $realAmount);
    }

    public function getAverage(array $filters): float
    {
        $sum = 0;
        $count = $this->repository->getCount($filters);
        foreach (['referral_amount', 'bonus_amount', 'dividend_amount', 'real_amount'] as $column) {
            $sum += $this->repository->getSum($column, $filters);
        }

        return (float) bcdiv((string) $sum, (string) $count, 8);
    }

    public function getSumRealPayments(string $accountUuid): float
    {
        return $this->repository->getSum('real_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
        ]);
    }

    public function getSumRealSells(string $accountUuid): float
    {
        return $this->repository->getSum('real_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::SELL->value,
        ]);
    }

    function getSumReferral(string $accountUuid): float
    {
        return $this->repository->getSum('referral_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
        ]);
    }

    function getSumReferralSell(string $accountUuid): float
    {
        return $this->repository->getSum('referral_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::SELL->value,
        ]);
    }

    function getSumBonus(string $accountUuid): float
    {
        return $this->repository->getSum('bonus_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
        ]);
    }

    function getSumBonusSell(string $accountUuid): float
    {
        return $this->repository->getSum('bonus_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::SELL->value,
        ]);
    }

    function getSumDividends(string $accountUuid): float
    {
        return $this->repository->getSum('dividend_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
        ]);
    }

    function getSumDividendsSell(string $accountUuid): float
    {
        return $this->repository->getSum('dividend_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::SELL->value,
        ]);
    }

    public function getDataForValuateSell(string $accountUuid): array
    {
        $referralAmount = $this-> getSumReferral($accountUuid);
        $bonusAmount = $this-> getSumBonus($accountUuid);
        $dividendAmount = $this-> getSumDividends($accountUuid);
        $realAmount = $this-> getSumRealPayments($accountUuid);
        $totalAmount = ($referralAmount + $bonusAmount + $dividendAmount + $realAmount);
        $allPaidDividends = $this->repository->getSum('dividend_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::WITHDRAWAL->value,
            ['dividend_amount', '!=', null],
        ]);
        $lastPayment = $this->repository->getLastPayment(PaymentDto::fromArray([
            'account_uuid' => $accountUuid,
            'type' =>  TypeEnum::CREDIT_FROM_CLIENT->value,
        ]));
        $sumUserSells = $this->getSumPayments($accountUuid, TypeEnum::SELL->value);
        $realAmountSell = $this-> getSumRealSells($accountUuid);

        return [$realAmount, $totalAmount, $allPaidDividends, $lastPayment, $sumUserSells, $realAmountSell];
    }

    public function getDataForConfirmSell(string $accountUuid): array
    {
        $referralAmount = $this-> getSumReferral($accountUuid);
        $bonusAmount = $this-> getSumBonus($accountUuid);
        $dividendsAmount = $this-> getSumDividends($accountUuid);
        $realAmount = $this-> getSumRealPayments($accountUuid);
        $totalAmount = ($referralAmount + $bonusAmount + $dividendsAmount + $realAmount);
        $allPaidDividends = $this->repository->getSum('dividend_amount', [
            'account_uuid' => $accountUuid,
            'type' => TypeEnum::WITHDRAWAL->value,
            ['dividend_amount', '!=', null],
        ]);
        $lastPayment = $this->repository->getLastPayment(PaymentDto::fromArray([
            'account_uuid' => $accountUuid,
            'type' =>  TypeEnum::CREDIT_FROM_CLIENT->value,
        ]));
        $sumUserSells = $this->getSumPayments($accountUuid, TypeEnum::SELL->value);
        $referralAmountSell = $this-> getSumReferralSell($accountUuid);
        $bonusAmountSell = $this-> getSumBonusSell($accountUuid);
        $dividendsAmountSell = $this-> getSumDividendsSell($accountUuid);
        $realAmountSell = $this-> getSumRealSells($accountUuid);

        return [
            $referralAmount,
            $bonusAmount,
            $dividendsAmount,
            $realAmount,
            $totalAmount,
            $allPaidDividends,
            $lastPayment,
            $sumUserSells,
            $realAmountSell,
            $referralAmountSell,
            $bonusAmountSell,
            $dividendsAmountSell,
            ];

    }

    public function checkBalance(string $accountUuid): bool
    {
        $sumUserPayments = $this->getSumPayments($accountUuid);
        $sumUserSells = $this->getSumPayments($accountUuid, TypeEnum::SELL->value);
        return $sumUserPayments > $sumUserSells;
    }
}
