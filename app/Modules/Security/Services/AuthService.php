<?php

namespace App\Modules\Security\Services;

use App\Models\User;
use App\Modules\Security\DTO\AuthDTO;
use App\Modules\Security\DTO\UserDTO;


class AuthService
{
    public function __construct(
        public HashService $hashService
    ) {}

    public function login(AuthDTO $authDTO): UserDTO
    {
        $user = User::query()->where(function ($query) use ($authDTO) {
            $query->where('email', $authDTO->login);
        })->first();

        if (!$user) {
            throw new \DomainException('Login or password is incorrect.');
        }

        $isRightPassword = $this->hashService->isHashEquals($user->password, $authDTO->password);

        if (!$isRightPassword) {
            throw new \DomainException('Login or password is incorrect.');
        }

        $token = auth()->login($user);

        return new UserDTO($user, $token);
    }
}
