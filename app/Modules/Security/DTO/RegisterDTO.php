<?php

namespace App\Modules\Security\DTO;

class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $password,
        public string $email,
    ) {}
}
