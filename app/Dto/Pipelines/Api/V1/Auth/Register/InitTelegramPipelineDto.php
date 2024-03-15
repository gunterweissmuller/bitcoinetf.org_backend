<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Register;

use App\Dto\DtoInterface;
use App\Dto\Models\Apollopayment\ClientsDto;
use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Referrals\InviteDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Models\Users\TelegramDto;

final class InitTelegramPipelineDto implements DtoInterface
{
    public function __construct(
        private ?AccountDto  $account,
        private ?ProfileDto  $profile,
        private ?EmailDto    $email,
        private ?CodeDto     $refCode,
        private ?CodeDto     $newCode,
        private ?InviteDto   $invite,
        private ?TelegramDto $telegram,
        private ?ClientsDto  $apolloClient,
        private bool         $isExists,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['account'] ?? null,
            $args['profile'] ?? null,
            $args['email'] ?? null,
            $args['ref_code'] ?? null,
            $args['new_code'] ?? null,
            $args['invite'] ?? null,
            $args['telegram'] ?? null,
            $args['apolloClient'] ?? null,
            $args['is_exists'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'profile' => $this->profile,
            'email' => $this->email,
            'ref_code' => $this->refCode,
            'invite' => $this->invite,
            'telegram' => $this->telegram,
            'apolloClient' => $this->apolloClient,
            'is_exists' => $this->isExists,
        ];
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
     * @return TelegramDto|null
     */
    public function getTelegram(): ?TelegramDto
    {
        return $this->telegram;
    }

    /**
     * @param TelegramDto|null $telegram
     * @return void
     */
    public function setTelegram(?TelegramDto $telegram): void
    {
        $this->telegram = $telegram;
    }

    /**
     * @return ClientsDto|null
     */
    public function getApolloClient(): ?ClientsDto
    {
        return $this->apolloClient;
    }

    /**
     * @param ClientsDto|null $apolloClient
     * @return void
     */
    public function setApolloClient(?ClientsDto $apolloClient): void
    {
        $this->apolloClient = $apolloClient;
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
