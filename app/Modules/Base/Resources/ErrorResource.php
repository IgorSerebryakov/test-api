<?php

namespace App\Modules\Base\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'errors' => $this->getMessage()
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->setStatusCode('422');
    }
}
