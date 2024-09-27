<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskStatusFirstItem"
 * )
 */

class TaskStatusFirstItem
{
    /**
     * @OA\Property(property="id", type="integer", example="1", description="id")
     *
     * @var int $id
     */
    public int $id;

    /**
     * @OA\Property(property="name", type="string", example="Completed", description="name")
     *
     * @var string $name;
     */
    public string $name;
}
