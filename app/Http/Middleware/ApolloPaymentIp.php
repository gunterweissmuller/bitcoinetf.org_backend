<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SpomkyLabs\Pki\ASN1\Type\Primitive\Boolean;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class ApolloPaymentIp
{
    protected $ipRanges = [
        '188.42.242.220',
        '188.42.242.228',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isValidIpRange($request->getClientIp())) {
            return response()->json(['error' => $request->getClientIp()], 403);
        }

        return $next($request);
    }

    private function isValidIpRange(string $ip): bool
    {
        return IpUtils::checkIp($ip, $this->ipRanges);
    }
}
