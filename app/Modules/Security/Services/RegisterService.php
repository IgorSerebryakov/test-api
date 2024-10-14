<?php

namespace App\Modules\Security\Services;

use App\Models\User;
use App\Modules\Security\DTO\RegisterDTO;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register(RegisterDTO $dto): User
    {
        $user = new User();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->email = $dto->email;

        $user->save();

        return $user;
    }
}
