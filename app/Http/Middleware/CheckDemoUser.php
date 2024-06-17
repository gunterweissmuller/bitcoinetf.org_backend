<?php

namespace App\Http\Middleware;

use App\Dto\Core\JwtPayloadDto;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckDemoUser
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accountUuid = JwtPayloadDto::fromArray($request->get('jwt_payload') ?? [])->toArray();
        
        if ($accountUuid == env('DEMO_ACCOUNT_UUID')) {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
