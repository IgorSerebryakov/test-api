<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="UpdateTaskStatusResponse"
 * )
 */

class UpdateTaskStatusResponse
{
    /**
     * @OA\Property(property="id", type="integer", example="1", description="id")
     *
     * @var int $id;
     *
     */
    public int $id;

    /**
     * @OA\Property(property="name", type="string", example="archived", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;
}
