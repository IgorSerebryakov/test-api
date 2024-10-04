<?php

namespace App\Schemas;


/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="RegisterRequest"
 * )
 */
class RegisterRequest
{
    /**
     * @OA\Property(property="name", type="string", example="Joe", description="name")
     *
     * @var string $name
     */
    public string $name;

    /**
     * @OA\Property(property="password", type="string", example="qwerty123", description="password")
     *
     * @var string $password
     */
    public string $password;

    /**
     * @OA\Property(property="email", type="email", example="Joedoe@email.com", description="email")
     *
     * @var string $email
     */
    public string $email;
}
