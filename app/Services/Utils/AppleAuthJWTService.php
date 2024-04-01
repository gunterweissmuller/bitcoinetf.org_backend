<?php

declare(strict_types=1);

namespace App\Services\Utils;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

final class AppleAuthJWTService
{
    private static ?AppleAuthJWTService $instance = null;

    private string $algorithm = 'ES256';

    private readonly AlgorithmManager $algorithmManager;

    private int $expiredTime = 86400 * 180;

    private function __construct()
    {
        $this->algorithmManager = new AlgorithmManager([
            new ES256(),
        ]);
    }

    /**
     * @return AppleAuthJWTService|null
     */
    public static function getInstance(): ?AppleAuthJWTService
    {
        if (self::$instance == null) {
            self::$instance = new AppleAuthJWTService();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public function generateToken(): string
    {
        try {
            $messageTitle = 'Apple Auth Secret key generation: ';
            $message = $messageTitle . 'apple JWT token updated successfully';

            $expireTime = Carbon::now()->addSecond($this->expiredTime);

            // Load private key
            $privateKey = JWKFactory::createFromKey(env('APPLE_PRIVATE_KEY'));

            // Build JWS
            $jwsBuilder = new JWSBuilder($this->algorithmManager);
            $jws = $jwsBuilder
                ->create()
                ->withPayload(json_encode([
                    'iss' => env('APPLE_TEAM_ID'),
                    'iat' => Carbon::now()->unix(),
                    'exp' => $expireTime->unix(),
                    'aud' => 'https://appleid.apple.com',
                    'sub' => env('APPLE_SERVICE_ID'),
                ]))
                ->addSignature($privateKey, [
                    'alg' => $this->algorithm,
                    'kid' => env('APPLE_KEY_ID'),
                ])
                ->build();

            // Serialize JWS
            $serializer = new CompactSerializer();
            $result = $this->createFile($serializer->serialize($jws, 0));

            if (!$result) {
                $message = $messageTitle . "can't generate file";
            }

        } catch (Exception $e) {
            $message = $messageTitle . $e->getMessage();
            Log::critical($message);
        }

        return $message;
    }

    /**
     * @param string $jwt
     * @return bool
     */
    public function isExpiredToken(string $jwt): bool
    {
        try {
            $serializer = new CompactSerializer();
            $jws = $serializer->unserialize($jwt);
            $payload = $jws->getPayload();
            $decodedPayload = json_decode($payload, true);

            // Check if the token has expired
            if (isset($decodedPayload['exp'])) {
                $expirationTime = $decodedPayload['exp'];
                $currentTime = Carbon::now()->timestamp;
                if ($currentTime > $expirationTime) {
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            Log::critical('Apple Auth Secret key expiration: ' . $e->getMessage());
        }
        return true;
    }

    /**
     * @return string|null
     */
    public function getSecretKey(): ?string
    {
        $secretKey = $this->getFile();

        if (!$secretKey || $this->isExpiredToken($secretKey)) {
            $this->generateToken();
            $secretKey = $this->getFile();
        }
        return $secretKey;
    }

    /**
     * @return string|null
     */
    private function getFile(): ?string
    {
        return Storage::disk('apple')->get(env('APPLE_SECRET_KEY_FILE_NAME'));
    }

    /**
     * @param string $token
     * @return bool
     */
    private function createFile(string $token): bool
    {
        return Storage::disk('apple')->put(env('APPLE_SECRET_KEY_FILE_NAME'), $token);
    }
}
