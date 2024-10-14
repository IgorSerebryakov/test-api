<?php

namespace App\Modules\Security\Requests;

use App\Modules\Base\Resources\ValidationResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'password' => ['required', 'string', Password::min(5)],
            'email' => ['required', 'email', Rule::unique('users', 'email')]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is empty!',
            'password.required' => 'Password is empty!',
            'password.min' => 'The password field must be at least 5 characters',
            'email.required' => 'Email is empty!',
            'email.unique' => 'User with same email already registered!'
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
