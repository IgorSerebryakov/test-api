<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskFirstItem"
 * )
 */
class StoreTaskRequest
{
    /**
     * @OA\Property(property="name", type="string", example="Do some job", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;
}
