<?php

namespace App\Modules\Task\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', Rule::exists('tasks', 'id')]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('task')
        ]);
    }
}
