<?php

namespace App\Modules\Task\Requests;

use App\Modules\Base\Resources\ValidationResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'unique:tasks'],
            'status' => ['required', Rule::exists('task_statuses', 'name')]
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Task already exists',
            'status.exists' => 'Status not found'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->messages();
        $errorMessages = [];

        foreach ($errors as $messages) {
            $errorMessages = array_merge($errorMessages, $messages);
        }

        throw new ValidationException(
            validator: $validator,
            response: new ValidationResource($errorMessages, 400)
        );
    }
}
