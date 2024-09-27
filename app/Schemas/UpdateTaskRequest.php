<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskFirstItem"
 * )
 */

class UpdateTaskRequest
{
    /**
     * @OA\Property(property="name", type="string", example="Do some job", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;

    /**
     * @OA\Property(property="status", type="string", example="Completed", description="status")
     *
     * @var string $status;
     *
     */
    public string $status;
}
