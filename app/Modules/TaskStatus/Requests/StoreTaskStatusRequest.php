<?php

namespace App\Modules\TaskStatus\Requests;

use App\Modules\Base\Resources\ValidationResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreTaskStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:task_statuses']
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Status already exists'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $message = $validator->errors()->messages()['name'];

        throw new ValidationException(
            validator: $validator,
            response: new ValidationResource($message, 400)
        );
    }
}
