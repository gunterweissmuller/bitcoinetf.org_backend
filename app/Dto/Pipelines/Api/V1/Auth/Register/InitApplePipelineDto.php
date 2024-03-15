<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Register;

use App\Dto\DtoInterface;
use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Referrals\InviteDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\AppleAccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;

final class InitApplePipelineDto implements DtoInterface
{
    public function __construct(
        private ?AppleAccountDto $appleAccount,
        private ?EmailDto        $email,
        private ?AccountDto      $account,
        private ?ProfileDto      $profile,
        private ?CodeDto         $refCode,
        private ?CodeDto         $newCode,
        private ?InviteDto       $invite,
        private bool             $isExists,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['apple_account'] ?? null,
            $args['email'] ?? null,
            $args['account'] ?? null,
            $args['profile'] ?? null,
            $args['ref_code'] ?? null,
            $args['new_code'] ?? null,
            $args['invite'] ?? null,
            $args['is_exists'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'apple_account' => $this->appleAccount,
            'email' => $this->email,
            'account' => $this->account,
            'profile' => $this->profile,
            'ref_code' => $this->refCode,
            'new_code' => $this->newCode,
            'invite' => $this->invite,
            'is_exists' => $this->isExists,
        ];
    }

    /**
     * @return AppleAccountDto|null
     */
    public function getAppleAccount(): ?AppleAccountDto
    {
        return $this->appleAccount;
    }

    /**
     * @param AppleAccountDto|null $appleAccount
     * @return void
     */
    public function setAppleAccount(?AppleAccountDto $appleAccount): void
    {
        $this->appleAccount = $appleAccount;
    }

    /**
     * @return AccountDto|null
     */
    public function getAccount(): ?AccountDto
    {
        return $this->account;
    }

    /**
     * @param AccountDto|null $account
     */
    public function setAccount(?AccountDto $account): void
    {
        $this->account = $account;
    }

    /**
     * @return ProfileDto|null
     */
    public function getProfile(): ?ProfileDto
    {
        return $this->profile;
    }

    /**
     * @param ProfileDto|null $profile
     */
    public function setProfile(?ProfileDto $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * @return EmailDto|null
     */
    public function getEmail(): ?EmailDto
    {
        return $this->email;
    }

    /**
     * @param EmailDto|null $email
     */
    public function setEmail(?EmailDto $email): void
    {
        $this->email = $email;
    }

    /**
     * @return CodeDto|null
     */
    public function getRefCode(): ?CodeDto
    {
        return $this->refCode;
    }

    /**
     * @param CodeDto|null $refCode
     */
    public function setRefCode(?CodeDto $refCode): void
    {
        $this->refCode = $refCode;
    }

    /**
     * @return CodeDto|null
     */
    public function getNewCode(): ?CodeDto
    {
        return $this->newCode;
    }

    /**
     * @param CodeDto|null $newCode
     */
    public function setNewCode(?CodeDto $newCode): void
    {
        $this->newCode = $newCode;
    }

    /**
     * @return InviteDto|null
     */
    public function getInvite(): ?InviteDto
    {
        return $this->invite;
    }

    /**
     * @param InviteDto|null $invite
     */
    public function setInvite(?InviteDto $invite): void
    {
        $this->invite = $invite;
    }

    /**
     * @return bool|null
     */
    public function getIsExists(): ?bool
    {
        return $this->isExists;
    }

    /**
     * @param bool|null $isExists
     */
    public function setIsExists(?bool $isExists): void
    {
        $this->isExists = $isExists;
    }
}
