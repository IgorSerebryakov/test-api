<?php

namespace App\Modules\Task\Requests;

use App\Modules\Base\Resources\ValidationResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TaskShowRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'id.integer' => 'Value must be an integer',
            'id.exists' => 'Task not found'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $message = $validator->errors()->first('id');

        if ($message == $this->messages()['id.exists']) {
            throw new ValidationException(
                validator: $validator,
                response: new ValidationResource($message, 404)
            );
        } else {
            throw new ValidationException(
                validator: $validator,
                response: new ValidationResource($message, 400)
            );
        }
    }
}
