<?php

namespace App\Modules\Security\Resources;

use AllowDynamicProperties;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->resource->getUser(),
            'token' => $this->resource->getToken(),
        ];
    }
}
