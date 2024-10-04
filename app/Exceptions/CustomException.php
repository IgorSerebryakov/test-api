<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class CustomException extends ValidationException
{
    public $message;

    public int $error;

    public function __construct(Validator $validator, )
    {
        parent::__construct($validator);
        $this->error = $error;
        $this->message = $message;

    }
    public function render(): JsonResponse
    {
        return response()->json([
            'type' => 'error',
            'message' => $this->message,
        ], $this->error);
    }
}
