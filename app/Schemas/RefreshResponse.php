<?php

namespace App\Schemas;


/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="RefreshResponse"
 * )
 */
class RefreshResponse
{
    /**
     * @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0Ojg4NzYvYXBpL3YxL2xvZ2luIiwiaWF0IjoxNzI3MzYwMjAxLCJleHAiOjE3MjczNjM4MDEsIm5iZiI6MTcyNzM2MDIwMSwianRpIjoicjVlSWxuT0s2QkN6QnZ6RiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.EaCdgb8MUlgDKQlijCSAPfodCeYO5XK-e4a1oeZMmpo", description="token")
     *
     * @var string $token
     */
    public string $token;
}
