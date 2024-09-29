<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskStatusResponse"
 * )
 */
class TaskStatusResponse
{
    /**
     * @OA\Property(property="id", type="integer", example="1", description="id")
     *
     * @var string $id;
     *
     */
    public string $id;

    /**
     * @OA\Property(property="name", type="string", example="Completed", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;
}
