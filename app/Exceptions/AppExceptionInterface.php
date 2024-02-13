<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\Core\AppError\CodeEnum;

interface AppExceptionInterface
{
    public function getErrorCode(): CodeEnum;
}
