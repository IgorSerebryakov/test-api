<?php

namespace App\Modules\Task\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'status' => $item->status->name
            ];
        })->toArray();
    }

    public function toResponse($request)
    {
        return response()->json($this->toArray($request));
    }
}
