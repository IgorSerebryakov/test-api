<?php

namespace App\Schemas;


/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="MeResponse"
 * )
 */
class MeResponse
{
    /**
     * @OA\Property(
     *     property="user",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(property="id", type="int", example="20", description="id"),
     *         @OA\Property(property="name", type="string", example="Joe", description="name"),
     *         @OA\Property(property="email", type="string", example="Joedoe@email.com", description="email")
     *     )
     * )
     *
     * @var array $user
     */
    public array $user;
}
