<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\Core\AppError\CodeEnum;
use App\Exceptions\AppExceptionInterface;
use App\Helpers\AppErrorHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

final class ResponseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        ResponseFactory::macro('exception', function (AppExceptionInterface|Throwable $e): JsonResponse {
            return response()->json([
                'error' => [
                    'code' => AppErrorHelper::getCode($e),
                    'message' => AppErrorHelper::getMessage($e),
                ],
            ], AppErrorHelper::getTransportCode((int) $e->getCode()));
        });

        ResponseFactory::macro('validation', function (array $errors, int $code): JsonResponse {
            return response()->json([
                'error' => [
                    'code' => 'ETF:'.CodeEnum::C000002->value,
                    'message' => 'validation error',
                    'validation' => $errors,
                ],
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        });
    }
}
