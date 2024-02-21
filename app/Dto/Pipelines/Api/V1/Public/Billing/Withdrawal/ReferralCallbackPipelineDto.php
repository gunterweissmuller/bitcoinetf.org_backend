<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\WithdrawalDto;
use App\Dto\Models\Users\AccountDto;

final class ReferralCallbackPipelineDto implements DtoInterface
{
    public function __construct(
        private AccountDto $account,
        private WithdrawalDto $withdrawal,
        private string $status,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['account'] ?? false,
            $args['withdrawal'] ?? null,
            $args['status'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'withdrawal' => $this->withdrawal,
            'status' => $this->status,
        ];
    }

    /**
     * @return AccountDto
     */
    public function getAccount(): AccountDto
    {
        return $this->account;
    }

    /**
     * @param  AccountDto  $account
     */
    public function setAccount(AccountDto $account): void
    {
        $this->account = $account;
    }

    /**
     * @return WithdrawalDto
     */
    public function getWithdrawal(): WithdrawalDto
    {
        return $this->withdrawal;
    }

    /**
     * @param  WithdrawalDto  $withdrawal
     */
    public function setWithdrawal(WithdrawalDto $withdrawal): void
    {
        $this->withdrawal = $withdrawal;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param  string  $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
