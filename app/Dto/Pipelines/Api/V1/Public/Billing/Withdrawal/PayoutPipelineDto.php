<?php

declare(strict_types=1);

namespace app\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\SellDto;

final class PayoutPipelineDto implements DtoInterface
{
    public function __construct(
        private ?SellDto     $sell,
        private ?string      $apollopaymentWithdrawalFeeToken,
    )
    {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['sell'] ?? null,
            $args['apollopaymentWithdrawalFeeToken'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'sell' => $this->sell,
            'apollopaymentWithdrawalFeeToken' => $this->apollopaymentWithdrawalFeeToken,
        ];
    }

    /**
     * @return SellDto|null
     */
    public function getSell(): ?SellDto
    {
        return $this->sell;
    }

    /**
     * @param SellDto|null $wallet
     */
    public function setSell(?SellDto $sell): void
    {
        $this->sell = Ssell;
    }

    /**
     * @return string|null
     */
    public function getApollopaymentWithdrawalFeeToken(): ?string
    {
        return $this->apollopaymentWithdrawalFeeToken;
    }

    /**
     * @param string|null $apollopaymentWithdrawalFeeToken
     * @return void
     */
    public function setApollopaymentWithdrawalFeeToken(?string $apollopaymentWithdrawalFeeToken): void
    {
        $this->apollopaymentWithdrawalFeeToken = $apollopaymentWithdrawalFeeToken;
    }
}
