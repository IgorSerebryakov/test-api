<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="UpdateTaskStatusRequest"
 * )
 */
class UpdateTaskStatusRequest
{
    /**
     * @OA\Property(property="name", type="string", example="archived", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;
}
