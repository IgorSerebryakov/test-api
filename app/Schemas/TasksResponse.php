<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="TasksResponse"
 * )
 */
class TasksResponse
{
   /**
    * @OA\Property(
    *     property="data",
    *     type="array",
    *     @OA\Items(
    *         anyOf={
    *             @OA\Schema(ref="#/components/schemas/TaskFirstItem"),
    *             @OA\Schema(ref="#/components/schemas/TaskSecondItem")
    *         }
    *     )
    * )
    *
    * @var array $data
    */
   public array $data;
}
