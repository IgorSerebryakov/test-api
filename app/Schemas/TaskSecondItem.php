<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskSecondItem"
 * )
 */
class TaskSecondItem
{
    /**
     * @OA\Property(property="id", type="integer", example="2", description="id")
     *
     * @var int $id
     */
    public int $id;

    /**
     * @OA\Property(property="name", type="string", example="Do some job", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;

    /**
     * @OA\Property(property="status", type="string", example="Not Completed", description="status")
     *
     * @var string $status;
     */
    public string $status;
}
