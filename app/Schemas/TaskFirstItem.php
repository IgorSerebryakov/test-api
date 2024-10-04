<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskFirstItem"
 * )
 */
class TaskFirstItem
{
    /**
     * @OA\Property(property="id", type="integer", example="1", description="id")
     *
     * @var int $id
     */
    public int $id;

    /**
     * @OA\Property(property="name", type="string", example="Do some exercises", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;

    /**
     * @OA\Property(property="status", type="string", example="Completed", description="status")
     *
     * @var string $status;
     */
    public string $status;
}
