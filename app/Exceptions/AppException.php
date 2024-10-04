<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class AppException extends Exception
{
    abstract public function status(): int;

    abstract public function error(): string;

    public function render(Request $request): Response
    {

    }
}
