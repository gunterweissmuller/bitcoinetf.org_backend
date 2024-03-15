<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Models\Billing\WithdrawalDto;

final class ReferralPipelineDto implements DtoInterface
{
    public function __construct(
        private ?WalletDto $wallet,
        private ?PaymentDto $payment,
        private ?WithdrawalDto $withdrawal,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['wallet'] ?? null,
            $args['payment'] ?? null,
            $args['withdrawal'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'wallet' => $this->wallet,
            'payment' => $this->payment,
            'withdrawal' => $this->withdrawal,
        ];
    }

    /**
     * @return WalletDto|null
     */
    public function getWallet(): ?WalletDto
    {
        return $this->wallet;
    }

    /**
     * @param  WalletDto|null  $wallet
     */
    public function setWallet(?WalletDto $wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * @return PaymentDto|null
     */
    public function getPayment(): ?PaymentDto
    {
        return $this->payment;
    }

    /**
     * @param  PaymentDto|null  $payment
     */
    public function setPayment(?PaymentDto $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return WithdrawalDto|null
     */
    public function getWithdrawal(): ?WithdrawalDto
    {
        return $this->withdrawal;
    }

    /**
     * @param  WithdrawalDto|null  $withdrawal
     */
    public function setWithdrawal(?WithdrawalDto $withdrawal): void
    {
        $this->withdrawal = $withdrawal;
    }
}
