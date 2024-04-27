<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Register;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Apollopayment\ClientsDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Models\Users\ProfileDto;
use App\Enums\Users\Account\ProviderTypeEnum;

final class ConfirmGooglePipelineDto implements DtoInterface
{
    public function __construct(
        private ?EmailDto         $email,
        private ?AccountDto       $account,
        private ?MetadataDto      $metadata,
        private ?ProfileDto       $profile,
        private ?JwtDto           $jwtAccess,
        private ?JwtDto           $jwtRefresh,
        private ?string           $websocketToken = null,
        private ?bool             $isFast,
        private ?ProviderTypeEnum $providerType,
        private ?ClientsDto       $apolloClient,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['email'] ?? null,
            $args['account'] ?? null,
            $args['metadata'] ?? null,
            $args['profile'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
            $args['is_fast'] ?? false,
            $args['provider_type'] ?? null,
            $args['apolloClient'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'account' => $this->account,
            'metadata' => $this->metadata,
            'profile' => $this->profile,
            'jwt_access' => $this->jwtAccess,
            'jwt_refresh' => $this->jwtRefresh,
            'websocket_token' => $this->websocketToken,
            'is_fast' => $this->isFast,
            'provider_type' => $this->providerType,
            'apolloClient' => $this->apolloClient,
        ];
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
     * @return MetadataDto|null
     */
    public function getMetadata(): ?MetadataDto
    {
        return $this->metadata;
    }

    /**
     * @param MetadataDto|null $metadata
     * @return void
     */
    public function setMetadata(?MetadataDto $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * @return array|null
     */
    public function getBonus(): ?array
    {
        return $this->bonus;
    }

    /**
     * @param array|null $bonus
     */
    public function setBonus(?array $bonus): void
    {
        $this->bonus = $bonus;
    }

    /**
     * @return JwtDto|null
     */
    public function getJwtAccess(): ?JwtDto
    {
        return $this->jwtAccess;
    }

    /**
     * @param JwtDto|null $jwtAccess
     */
    public function setJwtAccess(?JwtDto $jwtAccess): void
    {
        $this->jwtAccess = $jwtAccess;
    }

    /**
     * @return JwtDto|null
     */
    public function getJwtRefresh(): ?JwtDto
    {
        return $this->jwtRefresh;
    }

    /**
     * @param JwtDto|null $jwtRefresh
     */
    public function setJwtRefresh(?JwtDto $jwtRefresh): void
    {
        $this->jwtRefresh = $jwtRefresh;
    }

    /**
     * @return string|null
     */
    public function getWebsocketToken(): ?string
    {
        return $this->websocketToken;
    }

    /**
     * @param string|null $websocketToken
     */
    public function setWebsocketToken(?string $websocketToken): void
    {
        $this->websocketToken = $websocketToken;
    }

    public function isFast(): ?bool
    {
        return $this->isFast;
    }

    public function setIsFast(?bool $isFast): void
    {
        $this->isFast = $isFast;
    }

    public function getProviderType(): ?ProviderTypeEnum
    {
        return $this->providerType;
    }

    public function setProviderType(?ProviderTypeEnum $providerType): void
    {
        $this->providerType = $providerType;
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
}
