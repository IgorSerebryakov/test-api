<?php

namespace App\Modules\Security\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'password' => ['required', 'string', Password::min(5)],
            'email' => ['required', 'email', Rule::unique('users', 'email')]
        ];
    }
}
