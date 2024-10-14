<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use App\Orchid\Screens\TaskStatus\TaskStatusEditScreen;
use Database\Seeders\TaskStatusSeeder;
use Illuminate\Http\Request;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TaskStatusTestCase;
use Tests\TestCase;

class TaskStatusCreateUpdateDeleteScreenTest extends TaskStatusTestCase
{
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
            ->assertSee('Create')
            ->assertSee('name');
    }

    public function testCreate(): void
    {
        $data = [
            'task_status' => [
                'name' => 'New Task Status',
            ],
        ];

        $screen = new TaskStatusEditScreen();
        $screen->status = new TaskStatus();

        $request = Request::create(route('platform.task-status.edit'), 'POST', $data);
        $response = $screen->create($request);

        $this->assertEquals(302, $response->status());

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'New Task Status'
        ]);
    }

    public function testUpdate(): void
    {
        $status = TaskStatus::query()->where('id', 1)->first();

        $data = [
            'task_status' => [
                'name' => 'New Task Status',
            ],
        ];

        $screen = new TaskStatusEditScreen();
        $screen->status = $status;
        $request = Request::create(route('platform.task-status.edit', $status), 'POST', $data);
        $response = $screen->update($request);

        $this->assertEquals(302, $response->status());

        $this
            ->assertDatabaseMissing('task_statuses', [
                'id' => 1,
                'name' => 'Created'
            ])
            ->assertDatabaseHas('task_statuses', [
                'id' => 1,
                'name' => 'New Task Status'
            ]);
    }

    public function testDelete(): void
    {
        $status = TaskStatus::query()->where('id', 1)->first();

        $screen = new TaskStatusEditScreen();
        $screen->status = $status;

        $response = $screen->delete();

        $this->assertEquals(302, $response->status());

        $this->assertDatabaseMissing('task_statuses', [
            'id' => 1,
            'name' => 'Created'
        ]);
    }
}
