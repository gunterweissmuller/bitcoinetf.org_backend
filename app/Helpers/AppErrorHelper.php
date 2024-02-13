<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\Core\AppError\CodeEnum;
use App\Exceptions\AppExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class AppErrorHelper
{
    public static function getTransportCode(int $code): int
    {
        return self::isInvalid($code) ? Response::HTTP_I_AM_A_TEAPOT : $code;
    }

    public static function isInvalid(int $code): bool
    {
        return $code < 100 || $code >= 600;
    }

    public static function getCode(AppExceptionInterface|Throwable $e): string
    {
        return 'ETF:'.(method_exists($e, 'getErrorCode') ?
                $e->getErrorCode()->value :
                CodeEnum::C000000->value);
    }

    public static function getMessage(AppExceptionInterface|Throwable $e): string
    {
        $key = method_exists($e, 'getErrorCode') ?
            $e->getErrorCode()->value :
            CodeEnum::C000000->value;

        return ($e->getMessage() == '')
            ? trans('apperror.'.$key)
            : $e->getMessage();
    }
}
