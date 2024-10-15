<?php

namespace Tests\Feature;


use Illuminate\Testing\Fluent\AssertableJson;
use Tests\AuthTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends AuthTestCase
{
    public function testLogin(): void
    {
        $response = $this->postJson('/api/v1/login', [
            'login' => $this->registeredUser->email,
            'password' => 'password'
        ]);

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('user', [
                'id' => $this->registeredUser->id,
                'name' => $this->registeredUser->name,
                'email' => $this->registeredUser->email
            ])
            ->where('token', $response->json('token')));
    }

    public function testNotLoginWithIncorrectLoginAndPassword()
    {
        $response = $this->postJson('/api/v1/login', [
            'login' => 'IncorrectLogin',
            'password' => 'IncorrectPassword'
        ]);

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('error', 'User with that login is not found!'));
    }

    public function testNotLoginWithIncorrectPassword()
    {
        $response = $this->postJson('/api/v1/login', [
            'login' => $this->registeredUser->email,
            'password' => 'IncorrectPassword'
        ]);

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('error', 'Password is incorrect!'));
    }

    public function testLogout()
    {
        $loginResponse = $this->postJson('/api/v1/login', [
            'login' => $this->registeredUser->email,
            'password' => 'password'
        ]);

        $loginResponse->assertOk();

        $token = $loginResponse->json('token');

        $logoutResponse = $this->
            withHeaders([
                'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson('/api/v1/auth/logout');

        $logoutResponse
            ->assertOk();

        $this
            ->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson('/api/v1/auth/logout')
            ->assertStatus(401);

        $this->assertNull(auth()->user());
    }

    public function testRefresh()
    {
        $loginResponse = $this
            ->postJson('/api/v1/login', [
            'login' => $this->registeredUser->email,
            'password' => 'password'
        ])
            ->assertOk();

        $accessToken = $loginResponse->json('token');

        $this
            ->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])
            ->postJson('/api/v1/auth/me')
            ->assertOk();

        $refreshResponse = $this
            ->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])
            ->postJson('/api/v1/auth/refresh')
            ->assertOk();

        $refreshToken = $refreshResponse->json('token');

        $this
            ->withHeaders([
            'Authorization' => 'Bearer ' . $refreshToken,
        ])
            ->postJson('/api/v1/auth/me')
            ->assertOk();

        $this
            ->withHeaders([
            'Authorization' => 'Bearer ' . 'RandomToken',
        ])
            ->postJson('/api/v1/auth/me')
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('error', 'Invalid token'));

        $this
            ->assertNotEquals($accessToken, $refreshToken);
    }

    public function testMe()
    {
        $this
            ->withHeaders([
            'Authorization' => 'Bearer' . JWTAuth::fromUser($this->registeredUser),
        ])
            ->postJson('/api/v1/auth/me')
            ->assertOk();
    }
}
