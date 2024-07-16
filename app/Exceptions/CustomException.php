<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CustomException extends ValidationException
{
    public function render($request)
    {
        return new JsonResponse([
            'message' => 'Validation error',
            'errors' => $this->validator->errors()->getMessages()
        ], 422);
    }
}
