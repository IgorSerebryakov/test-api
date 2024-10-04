<?php

namespace App\Modules\Security\Services;

use Illuminate\Support\Facades\Hash;

class HashService
{
    public function isHashEquals(string $hash, string $password)
    {
        return Hash::check($password, $hash);
    }
}
