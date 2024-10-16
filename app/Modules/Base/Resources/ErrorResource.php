<?php

namespace App\Modules\Base\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'error' => $this->getMessage()
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->setStatusCode('400');
    }
}
