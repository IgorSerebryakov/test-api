<?php

namespace App\Modules\Task\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3'],
            'status' => ['required', Rule::exists('task_statuses', 'name')]
        ];
    }
}
