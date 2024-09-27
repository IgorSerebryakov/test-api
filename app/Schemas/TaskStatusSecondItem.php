<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskStatusSecondItem"
 * )
 */

class TaskStatusSecondItem
{
    /**
     * @OA\Property(property="id", type="integer", example="2", description="id")
     *
     * @var int $id
     */
    public int $id;

    /**
     * @OA\Property(property="name", type="string", example="Not Completed", description="name")
     *
     * @var string $name;
     */
    public string $name;
}
