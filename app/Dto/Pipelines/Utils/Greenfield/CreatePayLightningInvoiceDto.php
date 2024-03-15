<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Utils\Greenfield;

use App\Dto\DtoInterface;

final class CreatePayLightningInvoiceDto implements DtoInterface
{
    public function __construct(
        private ?string $bolt11,
        private ?string $amount,
        private ?string $maxFeePercent,
        private ?string $maxFeeFlat,
        private ?int $sendTimeout,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['BOLT11'] ?? null,
            $args['amount'] ?? null,
            $args['maxFeePercent'] ?? null,
            $args['maxFeeFlat'] ?? null,
            $args['sendTimeout'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'BOLT11' => $this->bolt11,
            'amount' => $this->amount,
            'maxFeePercent' => $this->maxFeePercent,
            'maxFeeFlat' => $this->maxFeeFlat,
            'sendTimeout' => $this->sendTimeout,
        ];
    }

    /**
     * @return string|null
     */
    public function getBolt11(): ?string
    {
        return $this->bolt11;
    }

    /**
     * @param  string|null  $bolt11
     */
    public function setBolt11(?string $bolt11): void
    {
        $this->bolt11 = $bolt11;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param  string|null  $amount
     */
    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string|null
     */
    public function getMaxFeePercent(): ?string
    {
        return $this->maxFeePercent;
    }

    /**
     * @param  string|null  $maxFeePercent
     */
    public function setMaxFeePercent(?string $maxFeePercent): void
    {
        $this->maxFeePercent = $maxFeePercent;
    }

    /**
     * @return string|null
     */
    public function getMaxFeeFlat(): ?string
    {
        return $this->maxFeeFlat;
    }

    /**
     * @param  string|null  $maxFeeFlat
     */
    public function setMaxFeeFlat(?string $maxFeeFlat): void
    {
        $this->maxFeeFlat = $maxFeeFlat;
    }

    /**
     * @return int|null
     */
    public function getSendTimeout(): ?int
    {
        return $this->sendTimeout;
    }

    /**
     * @param  int|null  $sendTimeout
     */
    public function setSendTimeout(?int $sendTimeout): void
    {
        $this->sendTimeout = $sendTimeout;
    }
}
