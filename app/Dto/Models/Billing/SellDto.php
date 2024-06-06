<?php

declare(strict_types=1);

namespace app\Dto\Models\Billing;

use App\Dto\DtoInterface;

final class SellDto implements DtoInterface
{
    public function __construct(
        private ?string $uuid,
        private ?string $accountUuid,
        private ?string $paymentUuid,
        private ?string $status,
        private ?string $period,
        private ?string $method,
        private ?string $destination,
        private ?float $value,
        private ?float $realAmount,
        private ?float $terminationFee,
        private ?float $transactionFee,
        private ?float $returnAllPaid,
        private ?string $createdAt,
        private ?string $updatedAt,
        private ?float $exchangeRateDeduction,
        private ?float $totalAmount,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['uuid'] ?? null,
            $args['account_uuid'] ?? null,
            $args['payment_uuid'] ?? null,
            $args['status'] ?? null,
            $args['period'] ?? null,
            $args['method'] ?? null,
            $args['destination'] ?? null,
            $args['value'] ?? null,
            $args['real_amount'] ?? null,
            $args['termination_fee'] ?? null,
            $args['transaction_fee'] ?? null,
            $args['return_all_paid'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
            $args['exchange_rate_deduction'] ?? null,
            $args['total_amount'] ?? null,
        );
    }

    public function toArray(?array $without = null): array
    {
        $data = [
            'uuid' => $this->uuid,
            'account_uuid' => $this->accountUuid,
            'payment_uuid' => $this->paymentUuid,
            'status' => $this->status,
            'period' => $this->period,
            'method' => $this->method,
            'destination' => $this->destination,
            'value' => $this->value,
            'real_amount' => $this->realAmount,
            'termination_fee' => $this->terminationFee,
            'transaction_fee' => $this->transactionFee,
            'return_all_paid' => $this->returnAllPaid,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'exchange_rate_deduction' => $this->exchangeRateDeduction,
            'total_amount' => $this->totalAmount,
        ];

        if ($without) {
            foreach ($without as $key) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param  string|null  $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    /**
     * @param  string|null  $accountUuid
     */
    public function setAccountUuid(?string $accountUuid): void
    {
        $this->accountUuid = $accountUuid;
    }

    /**
     * @return string|null
     */
    public function getPaymentUuid(): ?string
    {
        return $this->paymentUuid;
    }

    /**
     * @param  string|null  $paymentUuid
     */
    public function setPaymentUuid(?string $paymentUuid): void
    {
        $this->paymentUuid = $paymentUuid;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param  string|null  $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getPeriod(): ?string
    {
        return $this->period;
    }

    /**
     * @param  string|null  $period
     */
    public function setPeriod(?string $period): void
    {
        $this->period = $period;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param  string|null  $method
     */
    public function setMethod(?string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string|null
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @param  string|null  $destination
     */
    public function setDestination(?string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param  float|null  $value
     */
    public function setValue(?float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return float|null
     */
    public function getRealAmount(): ?float
    {
        return $this->realAmount;
    }

    /**
     * @param  float|null  $realAmount
     */
    public function setRealAmount(?float $realAmount): void
    {
        $this->realAmount = $realAmount;
    }

    /**
     * @return float|null
     */
    public function getTerminationFee(): ?float
    {
        return $this->terminationFee;
    }

    /**
     * @param  float|null  $terminationFee
     */
    public function setTerminationFee(?float $terminationFee): void
    {
        $this->terminationFee = $terminationFee;
    }

    /**
     * @return float|null
     */
    public function getTransactionFee(): ?float
    {
        return $this->transactionFee;
    }

    /**
     * @param  float|null  $transactionFee
     */
    public function setTransactionFee(?float $transactionFee): void
    {
        $this->transactionFee = $transactionFee;
    }

    /**
     * @return float|null
     */
    public function getReturnAllPaid(): ?float
    {
        return $this->returnAllPaid;
    }

    /**
     * @param  float|null  $returnAllPaid
     */
    public function setReturnAllPaid(?float $returnAllPaid): void
    {
        $this->returnAllPaid = $returnAllPaid;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param  string|null  $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param  string|null  $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return float|null
     */
    public function getExchangeRateDeduction(): ?float
    {
        return $this->exchangeRateDeduction;
    }

    /**
     * @param  float|null  $exchangeRateDeduction
     */
    public function setExchangeRateDeduction(?float $exchangeRateDeduction): void
    {
        $this->exchangeRateDeduction = $exchangeRateDeduction;
    }

    /**
     * @return float|null
     */
    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    /**
     * @param  float|null  $totalAmount
     */
    public function setTotalAmount(?float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }
    
}
