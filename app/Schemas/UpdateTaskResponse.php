<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="UpdateTaskResponse"
 * )
 */
class UpdateTaskResponse
{
    /**
     * @OA\Property(property="id", type="integer", example="1", description="id")
     *
     * @var string $id;
     *
     */
    public string $id;

    /**
     * @OA\Property(property="name", type="string", example="Do some job", description="name")
     *
     * @var string $name;
     *
     */
    public string $name;

    /**
     * @OA\Property(property="status_id", type="integer", example="1", description="status_id")
     *
     * @var int $status_id;
     *
     */
    public int $status_id;

    /**
     * @OA\Property(property="user_id", type="integer", example="1", description="user_id")
     *
     * @var int $user_id;
     *
     */
    public int $user_id;
}
