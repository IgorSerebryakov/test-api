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
     * @OA\Property(property="message", type="string", example="success", description="message")
     *
     * @var string $message
     *
     */
    public string $message;
}
