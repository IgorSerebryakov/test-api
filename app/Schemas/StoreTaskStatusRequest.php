<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="StoreTaskStatusRequest"
 * )
 */

class StoreTaskStatusRequest
{
    /**
     * @OA\Property(property="name", type="string", example="Completed", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;
}
