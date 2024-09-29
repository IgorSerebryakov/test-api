<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="array",
 *     title="TasksResponse",
 *     @OA\Items(
 *          anyOf={
 *              @OA\Schema(ref="#/components/schemas/TaskFirstItem"),
 *              @OA\Schema(ref="#/components/schemas/TaskSecondItem")
 *          }
 *     ),
 * )
 */
class TasksResponse {}
