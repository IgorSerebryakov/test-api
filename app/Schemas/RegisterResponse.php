<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="RegisterResponse"
 * )
 */
class RegisterResponse
{
    /**
     * @OA\Property(property="message", type="string", example="Registration was successful", description="message")
     *
     * @var string $name
     */
    public string $name;
}
