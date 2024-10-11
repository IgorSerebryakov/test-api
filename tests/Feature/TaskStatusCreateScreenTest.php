<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use App\Orchid\Screens\TaskStatus\TaskStatusEditScreen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TestCase;

class TaskStatusCreateScreenTest extends TestCase
{
    use RefreshDatabase;
    use ScreenTesting;

    public function testTaskStatusCreateScreen(): void
    {
        $user = User::factory()->admin()->create();

        $screen = $this
            ->screen('platform.task-status.edit')
            ->actingAs($user, 'web');

        $screen->display()
            ->assertOk()
            ->assertSee('Creating a new task status')
            ->assertSee('Create task status')
            ->assertSee('name');
    }

    public function testCreateNewTaskStatus(): void
    {
        $data = [
            'task_status' => [
                'name' => 'New Task Status',
            ],
        ];

        $screen = new TaskStatusEditScreen();

        $request = Request::create(route('platform.task-status.edit'), 'POST', $data);

        $response = $screen->createOrUpdate($request);

        $this->assertEquals(302, $response->status());

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'New Task Status'
        ]);
    }

    public function testUpdateNewTaskStatus(): void
    {
        $status = TaskStatus::query()->where('id', 1)->first();

        $data = [
            'task_status' => [
                'name' => 'New Task Status',
            ],
        ];

        $screen = new TaskStatusEditScreen();

        $request = Request::create(route('platform.task-status.edit', $status), 'POST', $data);

        $response = $screen->createOrUpdate($request);

        $this->assertEquals(302, $response->status());

        $this->assertDatabaseMissing('task_statuses', [
            'id' => 1,
            'name' => 'Created'
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'id' => 1,
            'name' => 'New Task Status'
        ]);
    }
}
