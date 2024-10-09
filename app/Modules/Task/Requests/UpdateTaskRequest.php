<?php

namespace App\Modules\Task\Requests;

use App\Modules\Base\Resources\ValidationResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', Rule::exists('tasks', 'id')],
            'name' => ['required', 'min:3', 'unique:tasks,name,' . $this->route('task')],
            'status' => ['required', Rule::exists('task_statuses', 'name')]
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
            'id.exists' => 'Task not found',
            'name.unique' => 'Task already exists',
            'status.exists' => 'Status not found'
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
        }

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
