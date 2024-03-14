<?php

declare(strict_types=1);

namespace App\Services\Utils;

use App\Dto\Core\JwtDto;
use App\Dto\Models\Users\AccountDto;
use App\Enums\Core\JWT\TypeEnum;
use App\Exceptions\Core\JWTExpiredException;
use App\Exceptions\Core\JWTSignatureInvalidException;
use Carbon\Carbon;
use Exception;
use Jose\Component\Checker\AlgorithmChecker;
use Jose\Component\Checker\ClaimCheckerManager;
use Jose\Component\Checker\ExpirationTimeChecker;
use Jose\Component\Checker\HeaderCheckerManager;
use Jose\Component\Checker\InvalidClaimException;
use Jose\Component\Checker\IssuedAtChecker;
use Jose\Component\Checker\NotBeforeChecker;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWS;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\JWSTokenSupport;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\Signature\Serializer\JWSSerializerManager;

final class JWTService
{
    private static ?JWTService $instance = null;

    private string $algorithm = 'ES256';

    private array $requiredHeaders = ['alg'];

    private array $requiredClaims = ['iat', 'nbf', 'exp', 'iss', 'jti', 'data'];

    private readonly AlgorithmManager $algorithmManager;

    private readonly array $config;

    private static string $pathKeys = 'storage/jwt';

    private function __construct()
    {
        $this->algorithmManager = new AlgorithmManager([
            new ES256(),
        ]);

        $this->config = config('jwt');
    }

    public static function getInstance(): ?JWTService
    {
        if (self::$instance == null) {
            self::$instance = new JWTService();
        }

        return self::$instance;
    }

    public function generateToken(
        TypeEnum $type,
        array $payload,
        string $subject = null,
        string $audience = null,
        string $expireTime = null,
        string $notBefore = null,
        string $jwtId = null,
    ): JwtDto {
        $expireTimeDefault = Carbon::now()->addMinutes($this->ttl($type));

        $payload = json_encode(
            [
                ...$payload,
                'iss' => $this->config['iss'],
                'sub' => $subject,
                'aud' => $audience,
                'exp' => $expireTime ?? $expireTimeDefault->unix(),
                'nbf' => $notBefore ? Carbon::now()->add($notBefore)->unix() : Carbon::now()->unix(),
                'iat' => Carbon::now()->unix(),
                'jti' => $jwtId ?? bin2hex(random_bytes(16)),
            ]
        );

        $JWSBuilder = new JWSBuilder($this->algorithmManager);
        $jws = $JWSBuilder
            ->create()
            ->withPayload($payload)
            ->addSignature(self::JWKPrivate(), ['alg' => $this->algorithm])
            ->build();

        return new JwtDto(
            (new CompactSerializer())->serialize($jws, 0),
            $expireTimeDefault->format('Y-m-d H:i:s'),
        );
    }

    public function verify(string $jwt): bool
    {
        return (bool) $this->jws($jwt);
    }

    public function getPayload(string $jwt): ?array
    {
        $payload = json_decode($this->jws($jwt)->getPayload(), true);

        return $payload['data'] ?? null;
    }

    public function jws(string $token): JWS
    {
        $serializerManager = new JWSSerializerManager([
            new CompactSerializer(),
        ]);

        try {
            $jws = $serializerManager->unserialize($token);

            $JWSVerifier = new JWSVerifier($this->algorithmManager);

            $JWSVerifier->verifyWithKey($jws, self::JWKPrivate(), 0);
            $this->checkHeader($jws);
            $this->checkClaims($jws);

            return $jws;
        } catch (Exception $e) {
            if ($e instanceof InvalidClaimException) {
                throw new JWTExpiredException();
            }

            throw new JWTSignatureInvalidException();
        }
    }

    private function checkHeader(JWS $jws): void
    {
        $headerCheckerManager = new HeaderCheckerManager(
            [new AlgorithmChecker([$this->algorithm])],
            [new JWSTokenSupport()]
        );

        $headerCheckerManager->check($jws, 0, $this->requiredHeaders);
    }

    private function checkClaims(JWS $jws): void
    {
        $claimCheckerManager = new ClaimCheckerManager(
            [
                new IssuedAtChecker(),
                new NotBeforeChecker(),
                new ExpirationTimeChecker(),
//                new AudienceChecker('Audience'),
            ]
        );

        $claims = json_decode($jws->getPayload(), true);

        $claimCheckerManager->check($claims, $this->requiredClaims);
    }

    public static function JWKPrivate(): JWK
    {
        return JWKFactory::createFromKeyFile(
            base_path(self::$pathKeys.'/private.pem'),
            null,
            ['use' => 'sig']
        );
    }

    public static function JWKPublic(): JWK
    {
        return JWKFactory::createFromKeyFile(
            base_path(self::$pathKeys.'/public.pem'),
            null,
            ['use' => 'sig']
        );
    }

    public static function getAccessPayload(AccountDto $account): array
    {
        return [
            'account' => [
                'uuid' => $account->getUuid(),
                'number' => $account->getNumber(),
                'username' => $account->getUsername(),
                'type' => $account->getType(),
                'status' => $account->getStatus(),
            ],
        ];
    }

    public static function getRefreshPayload(string $accountUuid): array
    {
        return [
            'account_uuid' => $accountUuid,
        ];
    }

    private function ttl(TypeEnum $type): int
    {
        return (int) $this->config['ttl'][$type->value];
    }
}
