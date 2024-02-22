<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Models\Billing\WithdrawalDto;
use App\Dto\Pipelines\Utils\Greenfield\LightningInvoiceDto;
use App\Dto\Pipelines\Utils\Greenfield\PayLightningInvoiceDto;
use App\Dto\Pipelines\Utils\Greenfield\PayoutDto;
use App\Dto\Pipelines\Utils\Greenfield\PullPaymentDto;

final class DividendPipelineDto implements DtoInterface
{
    public function __construct(
        private ?WalletDto $wallet,
        private ?PaymentDto $payment,
        private ?WithdrawalDto $withdrawal,
        private ?PullPaymentDto $pullPayment,
        private ?PayoutDto $payout,
        private ?LightningInvoiceDto $lightningInvoice,
        private ?PayLightningInvoiceDto $payLightningInvoice,
        private readonly string $method,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['wallet'] ?? null,
            $args['payment'] ?? null,
            $args['withdrawal'] ?? null,
            $args['pull_payment'] ?? null,
            $args['payout'] ?? null,
            $args['lightning_invoice'] ?? null,
            $args['pay_lightning_invoice'] ?? null,
            $args['method'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'wallet' => $this->wallet,
            'payment' => $this->payment,
            'withdrawal' => $this->withdrawal,
            'pull_payment' => $this->pullPayment,
            'payout' => $this->payout,
            'lightning_invoice' => $this->lightningInvoice,
            'pay_lightning_invoice' => $this->payLightningInvoice,
            'method' => $this->method,
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

    /**
     * @return PullPaymentDto|null
     */
    public function getPullPayment(): ?PullPaymentDto
    {
        return $this->pullPayment;
    }

    /**
     * @param  PullPaymentDto|null  $pullPayment
     */
    public function setPullPayment(?PullPaymentDto $pullPayment): void
    {
        $this->pullPayment = $pullPayment;
    }

    /**
     * @return PayoutDto|null
     */
    public function getPayout(): ?PayoutDto
    {
        return $this->payout;
    }

    /**
     * @param  PayoutDto|null  $payout
     */
    public function setPayout(?PayoutDto $payout): void
    {
        $this->payout = $payout;
    }

    /**
     * @return LightningInvoiceDto|null
     */
    public function getLightningInvoice(): ?LightningInvoiceDto
    {
        return $this->lightningInvoice;
    }

    /**
     * @param  LightningInvoiceDto|null  $lightningInvoice
     */
    public function setLightningInvoice(?LightningInvoiceDto $lightningInvoice): void
    {
        $this->lightningInvoice = $lightningInvoice;
    }

    /**
     * @return PayLightningInvoiceDto|null
     */
    public function getPayLightningInvoice(): ?PayLightningInvoiceDto
    {
        return $this->payLightningInvoice;
    }

    /**
     * @param  PayLightningInvoiceDto|null  $payLightningInvoice
     */
    public function setPayLightningInvoice(?PayLightningInvoiceDto $payLightningInvoice): void
    {
        $this->payLightningInvoice = $payLightningInvoice;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
