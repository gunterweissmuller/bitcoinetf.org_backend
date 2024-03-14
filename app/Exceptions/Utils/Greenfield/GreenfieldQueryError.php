<?php

declare(strict_types=1);

namespace App\Exceptions\Utils\Greenfield;

use App\Enums\Core\AppError\CodeEnum;
use App\Exceptions\AppExceptionInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class GreenfieldQueryError extends RuntimeException implements AppExceptionInterface
{
    public function __construct(
        string $message = '',
        int $code = Response::HTTP_BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getErrorCode(): CodeEnum
    {
        return CodeEnum::C070001;
    }
}
