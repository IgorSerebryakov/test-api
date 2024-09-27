<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Desc",
 *     type="object",
 *     title="SuccessResponse"
 * )
 */
class SuccessResponse
{
    /**
     * @OA\Property(property="status", type="bool", example="true", description="status")
     *
     * @var bool $status
     *
     */
    public bool $status;
}
