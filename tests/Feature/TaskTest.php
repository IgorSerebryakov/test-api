<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TaskTestCase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskTest extends TaskTestCase
{
    public function testNotAuthHasNoAccess(): void
    {
        $responseGetAll = $this->getJson('/api/v1/auth/tasks');
        $responseGetOne = $this->getJson('/api/v1/auth/tasks/1');
        $responseCreate = $this->postJson('/api/v1/auth/tasks');
        $responseUpdate = $this->patchJson('/api/v1/auth/tasks/1');
        $responseDelete = $this->deleteJson('/api/v1/auth/tasks/1');

        $this->assertGuest();

        $responseGetAll
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        $responseGetOne
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        $responseCreate
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        $responseUpdate
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        $responseDelete
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function testGetAll()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();


        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/tasks');

        $this->assertAuthenticatedAs($user);

        $expectedJson = [
            [
                "id" => 1,
                'name' => "Correct an error in some string",
                "status" => "Created"
            ],
            [
                "id" => 2,
                "name" => "Finish the home page design",
                "status" => "In process",
            ],
            [
                "id" => 3,
                "name" => "Refactor authorization",
                "status" => "Completed"
            ],
            [
                "id" => 4,
                "name" => "Improve the database preparation command",
                "status" => "Created",
            ],
            [
                "id" => 5,
                "name" => "Correct search",
                "status" => "In process"
            ]
        ];

        $response
            ->assertStatus(200)
            ->assertJson($expectedJson);
    }

    public function testCreate()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->postJson('/api/v1/auth/tasks', ['name' => 'Do some job']);

        $this->assertDatabaseHas('tasks', [
            'id' => 6,
            'name' => 'Do some job',
            'status_id' => 1,
            'user_id' => 6
        ]);

        $this->assertAuthenticatedAs($user);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 6)
                ->where('name', 'Do some job')
                ->where('statusId', 1)
                ->where('userId', 6)
            );
        $response->assertStatus(201);
    }

    public function testNotCreateWithEmptyName()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->postJson('/api/v1/auth/tasks', ['name' => '']);

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'The name field is required.'
                ])
            );
    }

    public function testNotCreateWithExistingName()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->postJson('/api/v1/auth/tasks', ['name' => 'Correct an error in some string']);

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'Task already exists'
                ])
            );
    }

    public function testGetOne()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/tasks/1');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('name', 'Correct an error in some string')
                ->where('statusId', 1)
                ->where('userId', 6)
            );
    }

    public function testNotGetOneWithNotExistingId()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/tasks/6');

        $response
            ->assertStatus(404)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Task not found')
            );
    }

    public function testNotGetOneWithIdNotInteger()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/tasks/test');

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Value must be an integer')
            );
    }

    public function testNotGetOneWithIdBelongingToAnotherUser()
    {
        $user = User::query()
            ->where('id', 5)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/tasks/1');

        $response
            ->assertStatus(403)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'This task belongs to another user')
            );
    }

    public function testUpdate()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patch('/api/v1/auth/tasks/1', [
            'name' => 'Correct an error in some integer',
            'status' => 'In process'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('name', 'Correct an error in some integer')
                ->where('statusId', 2)
                ->where('userId', 6)
            );


    }

    public function testUpdateToSameNameAndSameStatus()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patch('/api/v1/auth/tasks/1', [
            'name' => 'Correct an error in some string',
            'status' => 'Created'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('name', 'Correct an error in some string')
                ->where('statusId', 1)
                ->where('userId', 6)
            );
    }

    public function testNotUpdateToExistingName()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patch('/api/v1/auth/tasks/1', [
            'name' => 'Finish the home page design',
            'status' => 'Created'
        ]);

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'Task already exists'
                ])
            );
    }

    public function testNotUpdateWithNotExistingId()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patchJson('/api/v1/auth/tasks/10');

        $response
            ->assertStatus(404)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Task not found')
            );
    }

    public function testNotUpdateWithIdNotInteger()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patchJson('/api/v1/auth/tasks/test');

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'Value must be an integer',
                    'The name field is required.',
                    'The status field is required.'
                ])
            );
    }

    public function testNotUpdateWithIdBelongingToAnotherUser()
    {
        $user = User::query()
            ->where('id', 5)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patchJson('/api/v1/auth/tasks/1', [
            'name' => 'Correct an error in some string',
            'status' => 'In process'
        ]);

        $response
            ->assertStatus(403)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'This task belongs to another user')
            );
    }

    public function testDelete()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->delete('/api/v1/auth/tasks/1');

        $this->assertDatabaseMissing('tasks', [
            'id' => 1,
            'name' => 'Correct an error in some string',
            'status_id' => 1,
            'user_id' => 6
        ]);

        $response->assertStatus(204);
    }

    public function testNotDeleteWithNotExistingId()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->delete('/api/v1/auth/tasks/6');

        $response
            ->assertStatus(404)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Task not found')
            );
    }

    public function testNotDeleteWithIdNotInteger()
    {
        $user = User::query()
            ->where('id', 6)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->delete('/api/v1/auth/tasks/test');

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Value must be an integer')
            );
    }

    public function testNotDeleteWithIdBelongingToAnotherUser()
    {
        $user = User::query()
            ->where('id', 5)
            ->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->delete('/api/v1/auth/tasks/1');

        $response
            ->assertStatus(403)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'This task belongs to another user')
            );
    }
}
