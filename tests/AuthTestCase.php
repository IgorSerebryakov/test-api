<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\TaskStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class AuthTestCase extends BaseTestCase
{
    use RefreshDatabase;
    protected User $registeredUser;
    protected function setUp(): void
    {
        parent::setUp();

        $this->registeredUser = User::factory()->create([
            'name' => 'TestUser',
            'email' => 'test@email.com',
            'remember_token' => null
        ]);
    }
}
