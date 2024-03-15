<?php

declare(strict_types=1);

namespace App\Exceptions\Core;

use App\Enums\Core\AppError\CodeEnum;
use App\Exceptions\AppExceptionInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class NotFoundException extends RuntimeException implements AppExceptionInterface
{
    public function __construct(
        string $message = '',
        int $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getErrorCode(): CodeEnum
    {
        return CodeEnum::C000001;
    }
}
