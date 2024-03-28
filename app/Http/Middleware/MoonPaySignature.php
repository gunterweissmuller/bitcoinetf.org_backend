<?php

namespace app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MoonPaySignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $moon_pay_signature = $request->header('moonpay-signature-v2');
        $timestamp = $this->getTimestampFromHeader($moon_pay_signature);
        $payload = $this->getPayload($request);
        $signed_payload = $this->getSignedPayload($timestamp, $payload);

        if (!$this->checkSignature($moon_pay_signature, $signed_payload)) {
            return response()->json(['error' => 'PUBLIC_KEY'], 403);
        }

        return $next($request);
    }

    private function getTimestampFromHeader(string $header): string
    {
        $elements = explode(',', $header);
        foreach ($elements as $element) {
            $pair = explode('=', $element);
            if ($pair[0] === 't') {
                return $pair[1];
            }
        }
        return '';
    }

    private function getPayload(Request $request): string
    {
        return json_encode($request->all());
    }

    private function getSignedPayload(string $timestamp, string $payload): string
    {
        return $timestamp . '.' . $payload;
    }

    private function checkSignature(string $signature, string $signed_payload): bool
    {
        $hashedPayload = hash_hmac('sha256', $signed_payload, env('MOONPAY_WEBHOOK'));

        return $signature === $hashedPayload;
    }

}
