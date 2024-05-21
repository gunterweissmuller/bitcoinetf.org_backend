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
        '94.242.240.228',
        '188.42.242.132',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isValidIpRange($request->header('cf-connecting-ip'))) {
            return response()->json(['error' => 'Access denied', 403]);
        }

        return $next($request);
    }

    private function isValidIpRange(string $ip): bool
    {
        return IpUtils::checkIp($ip, $this->ipRanges);
    }
}
