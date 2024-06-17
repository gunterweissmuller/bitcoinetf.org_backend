<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Users\Account\TypeEnum;
use App\Exceptions\Core\AccessForbiddenException;
use App\Exceptions\Core\JWTExpiredException;
use App\Exceptions\Core\JWTNotFoundException;
use App\Models\Auth\RefreshToken;
use App\Services\Utils\JWTService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class Authenticate
{
    public function handle(
        Request $request,
        Closure $next,
        ?string $type = 'client'
    ): JsonResponse|Response|StreamedResponse {
        if ($apiKey = $request->header('X-API-Key')) {
            if ($apiKey != env('PAYMENT_CALLBACK_KEY')) {
                throw new AccessForbiddenException();
            }

            return $next($request);
        }

        /** @var JWTService $jwtService */
        $jwtService = app(JWTService::class);

        $accessToken = $request->header('Authorization');
        if (is_null($accessToken)) {
            throw new JWTNotFoundException();
        }

        $accessToken = explode(' ', $accessToken)[1];
        $payload = $jwtService->getPayload($accessToken);

        $hasTokens = (bool) RefreshToken::whereAccountUuid($payload['account']['uuid'])
            ->whereNull('revoked_at')
            ->count();

        if (!$hasTokens) {
            throw new JWTExpiredException('Token has been revoked');
        }

        if (
            $type == 'editor'
            && !in_array($payload['account']['type'], ['editor', 'moderator', 'admin'])
        ) {
            throw new AccessForbiddenException('editor');
        } else if (
            $type == 'moderator'
            && !in_array($payload['account']['type'], ['moderator', 'admin'])
        ) {
            throw new AccessForbiddenException('moderator');
        } else if (
            $type == 'admin'
            && $payload['account']['type'] != 'admin'
        ) {
            throw new AccessForbiddenException('admin');
        }

        $request->offsetSet('jwt_payload', $payload['account']);

        return $next($request);
    }
}
