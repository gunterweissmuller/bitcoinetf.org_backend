<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Core\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class Handler extends ExceptionHandler
{
    protected $dontReport = [
        HttpException::class,
        ValidationException::class,
        ModelNotFoundException::class,
    ];

    public function render($request, Throwable $e): Response|JsonResponse
    {
        if ($e instanceof ValidationException) {
            return $e->getResponse();
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->__call('exception', [new NotFoundException()]);
        }

        return response()->__call('exception', [$e]);
    }
}
