<?php

namespace App\Modules\TaskStatus\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStatusDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'int']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('task_status'),
        ]);
    }
}
