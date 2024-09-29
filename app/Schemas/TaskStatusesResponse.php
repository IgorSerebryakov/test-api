<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="array",
 *     title="TaskStatusesResponse",
 *     @OA\Items(
 *          anyOf={
 *              @OA\Schema(ref="#/components/schemas/TaskStatusFirstItem"),
 *              @OA\Schema(ref="#/components/schemas/TaskStatusSecondItem")
 *          }
 *      )
 * )
 */

class TaskStatusesResponse {}
