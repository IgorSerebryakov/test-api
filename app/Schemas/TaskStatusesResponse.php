<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TaskStatusesResponse"
 * )
 */

class TaskStatusesResponse
{
    /**
     * @OA\Property(
     *     property="data",
     *     type="array",
     *     @OA\Items(
     *         anyOf={
     *             @OA\Schema(ref="#/components/schemas/TaskStatusFirstItem"),
     *             @OA\Schema(ref="#/components/schemas/TaskStatusSecondItem")
     *         }
     *     )
     * )
     *
     * @var array $data;
     */
    public array $data;
}
