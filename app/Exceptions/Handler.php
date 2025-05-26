<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Http\Responses\SystemResponse;
use Illuminate\Validation\ValidationException;


use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return SystemResponse::error( $exception->validator->errors()->first(), 422);
        }

        if ($request->expectsJson()) {
            return SystemResponse::error($exception->getMessage(), $exception->getCode() ?: 500);
        }

        return parent::render($request, $exception);
    }

}
