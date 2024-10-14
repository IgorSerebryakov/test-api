<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testRegister(): void
    {
        $response = $this
            ->postJson('/api/v1/register', [
                'name' => 'RandomName',
                'password' => 'qwerty1234',
                'email' => 'random@email.com'
            ]);

        $this
            ->assertDatabaseHas('users', [
                'id' => 1,
                'name' => 'RandomName',
                'email' => 'random@email.com'
            ]);

        $registeredUser = User::query()
            ->where('id', 1)
            ->first();

        $this
            ->assertTrue(Hash::check('qwerty1234', $registeredUser->password));

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'Registration was successful'));

        $response->assertStatus(200);
    }

    public function testNotRegisterWithExistingEmail()
    {
        $this
            ->postJson('/api/v1/register', [
                'name' => 'RandomName',
                'password' => 'qwerty1234',
                'email' => 'random@email.com'
            ]);

        $this
            ->assertDatabaseHas('users', [
                'id' => 1,
                'name' => 'RandomName',
                'email' => 'random@email.com'
            ]);

        $response = $this
            ->postJson('/api/v1/register', [
                'name' => 'NewName',
                'password' => 'qwerty12341234',
                'email' => 'random@email.com'
            ]);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'User with same email already registered!'
                ])
            );
        $response->assertStatus(400);
    }

    public function testNotRegisterWithEmptyName()
    {
        $response = $this
            ->postJson('/api/v1/register', [
                'name' => '',
                'password' => 'qwerty1234',
                'email' => 'random@email.com'
            ]);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'Name is empty!'
                ])
            );
        $response->assertStatus(400);
    }
}
