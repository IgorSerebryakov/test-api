<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="AuthRequest",
 * )
 */
class AuthRequest
{
   /**
    * @OA\Property(property="login", type="string", example="Joedoe@email.com", description="login")
    *
    * @var string $login
    */
   public string $login;

   /**
    * @OA\Property(property="password", type="string", example="qwerty123", description="password")
    *
    * @var string $password
    */
   public string $password;
}
