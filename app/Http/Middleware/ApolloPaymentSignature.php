<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SpomkyLabs\Pki\ASN1\Type\Primitive\Boolean;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class ApolloPaymentSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('x-api-public-key') != env('APOLLO_PAYMENT_PUBLIC_KEY')) {
            return response()->json(['error' => 'PUBLIC_KEY error'], 403);
        }

        if (!$this->checkSignature($request->header('x-api-signature'), $request->all())
        ) {
            return response()->json(['error' => 'CHECK_SIGNATURE error'], 403);
        }

        return $next($request);
    }

    private function checkSignature(string $signature, array $payload): bool
    {
        $hashedPayload = hash_hmac('sha256', json_encode($payload), env('APOLLO_PAYMENT_PRIVATE_KEY'));

        return $signature === $hashedPayload;
    }


}
