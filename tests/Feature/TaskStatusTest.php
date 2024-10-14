<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TaskStatusSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TaskStatusTestCase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskStatusTest extends TaskStatusTestCase
{
    public function testNotAuthHasNoAccess(): void
    {
        $this->seed(DatabaseSeeder::class);

        $responseGetAll = $this->getJson('/api/v1/auth/task-statuses');
        $responseGetOne = $this->getJson('/api/v1/auth/task-statuses/1');
        $responseCreate = $this->postJson('/api/v1/auth/task-statuses');
        $responseUpdate = $this->patchJson('/api/v1/auth/task-statuses/1');
        $responseDelete = $this->deleteJson('/api/v1/auth/task-statuses/1');

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
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/task-statuses');

        $this->assertAuthenticatedAs($user);

        $expectedJson = [
            [
                "id" => 1,
                "name" => "Created"
            ],
            [
                "id" => 2,
                "name" => "In process"
            ],
            [
                "id" => 3,
                "name" => "Completed"
            ],
        ];

        $response
            ->assertStatus(200)
            ->assertJson($expectedJson);
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->postJson('/api/v1/auth/task-statuses', ['name' => 'Done']);

        $this->assertDatabaseHas('task_statuses', [
            'id' => 4,
            'name' => 'Done'
        ]);

        $this->assertAuthenticatedAs($user);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('id', 4)
                    ->where('name', 'Done')
            );
        $response->assertStatus(201);
    }

    public function testNotCreateWithEmptyName()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->postJson('/api/v1/auth/task-statuses', ['name' => '']);

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
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->postJson('/api/v1/auth/task-statuses', ['name' => 'Created']);

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'Status already exists'
                ])
            );
    }

    public function testGetOne()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/task-statuses/1');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('name', 'Created')
            );
    }

    public function testNotGetOneWithNotExistingId()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/task-statuses/4');

        $response
            ->assertStatus(404)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Status not found')
            );
    }

    public function testNotGetOneWithIdNotInteger()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->getJson('/api/v1/auth/task-statuses/test');

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Value must be an integer')
            );
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patch('/api/v1/auth/task-statuses/1', [
            'name' => 'Archived'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('name', 'Archived')
            );
    }

    public function testUpdateToSameName()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patch('/api/v1/auth/task-statuses/1', [
            'name' => 'Created'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('name', 'Created')
            );
    }

    public function testNotUpdateToExistingName()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patch('/api/v1/auth/task-statuses/1', [
            'name' => 'Completed'
        ]);

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'Status already exists'
                ])
            );
    }

    public function testNotUpdateWithNotExistingId()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patchJson('/api/v1/auth/task-statuses/4');

        $response
            ->assertStatus(404)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Status not found')
            );
    }

    public function testNotUpdateWithIdNotInteger()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->patchJson('/api/v1/auth/task-statuses/test');

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', [
                    'Value must be an integer',
                    'The name field is required.'
                ])
            );
    }

    public function testDelete()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->delete('/api/v1/auth/task-statuses/1');

        $this->assertDatabaseMissing('task_statuses', [
            'id' => 1,
            'name' => 'Created'
        ]);

        $response->assertStatus(204);

    }

    public function testNotDeleteWithNotExistingId()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->delete('/api/v1/auth/task-statuses/4');

        $response
            ->assertStatus(404)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Status not found')
            );
    }

    public function testNotDeleteWithIdNotInteger()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->delete('/api/v1/auth/task-statuses/test');

        $response
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('type', 'error')
                ->where('message', 'Value must be an integer')
            );
    }
}
