<?php

namespace App\Modules\Base\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidationResource extends JsonResource
{
    protected int $code;
    public static $wrap = null;
    public function __construct($message, $code = 400)
    {
        parent::__construct($message);
        $this->code = $code;
    }
    public function toArray(Request $request): array
    {
        return [
            'type' => 'error',
            'message' => $this->resource
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->setStatusCode($this->code);
    }
}
