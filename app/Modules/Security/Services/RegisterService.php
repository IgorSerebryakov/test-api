<?php

namespace App\Modules\Security\Services;

use App\Models\User;
use App\Modules\Security\DTO\RegisterDTO;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register(RegisterDTO $registerDTO): User
    {
        $user = new User();
        $user->name = $registerDTO->name;
        $user->password = Hash::make($registerDTO->password);
        $user->email = $registerDTO->email;

        $user->save();

        return $user;
    }
}
