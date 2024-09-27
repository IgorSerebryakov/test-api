<?php

namespace App\Modules\Base\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => true,
        ];
    }
}
