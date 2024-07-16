<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Обработка ошибок валидации
        $this->renderable(function (ValidationException $exception, $request) {
            if (!$request->wantsJson()) {
                return null;
            }

            throw CustomException::withMessages(
                $exception->validator->getMessageBag()->getMessages()
            );
        });

        // Обработка ошибок 404
        $this->renderable(function (Throwable $exception, Request $request) {
            if (!$exception instanceof NotFoundHttpException) {
                return null;
            }
            
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Not found',
                ], 404);
            }
        });
    }
}
