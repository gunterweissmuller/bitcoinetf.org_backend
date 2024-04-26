<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Auth\Login;

use App\Dto\Core\JwtDto;
use App\Dto\DtoInterface;
use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;

final class LoginOneTimePasswordPipelineDto implements DtoInterface
{
    public function __construct(
        private ?EmailDto   $email,
        private ?AccountDto $account,
        private ?CodeDto    $code,
        private ?JwtDto     $jwtAccess,
        private ?JwtDto     $jwtRefresh,
        private ?string     $websocketToken = null,
    )
    {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['email'] ?? null,
            $args['account'] ?? null,
            $args['code'] ?? null,
            $args['jwt_access'] ?? null,
            $args['jwt_refresh'] ?? null,
            $args['websocket_token'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'account' => $this->account,
            'code' => $this->code,
            'jwt_access' => $this->jwtAccess,
            'jwt_refresh' => $this->jwtRefresh,
            'websocket_token' => $this->websocketToken,
        ];
    }

    public function getWebsocketToken(): string
    {
        return $this->websocketToken;
    }

    public function setWebsocketToken(?string $value): void
    {
        $this->websocketToken = $value;
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
     * @return CodeDto|null
     */
    public function getCode(): ?CodeDto
    {
        return $this->code;
    }

    /**
     * @param CodeDto|null $code
     */
    public function setCode(?CodeDto $code): void
    {
        $this->code = $code;
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
}
