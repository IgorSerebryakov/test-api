<?php

namespace App\Modules\TaskStatus\Requests;

use App\Modules\Base\Resources\ValidationResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateTaskStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', Rule::exists('task_statuses', 'id')],
            'name' => ['required', 'min:3', 'unique:task_statuses,name,' . $this->route('task_status')],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('task_status')
        ]);
    }

    public function messages(): array
    {
        return [
            'id.integer' => 'Value must be an integer',
            'id.exists' => 'Task not found',
            'name.unique' => 'Status already exists',
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
}
