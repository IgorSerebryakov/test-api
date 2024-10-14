<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Orchid\Screens\Task\TaskEditScreen;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TaskTestCase;
use Tests\TestCase;

class TaskUpdateScreenTest extends TaskTestCase
{
    use ScreenTesting;

    protected $seed = true;

    public function testUpdate(): void
    {
        $task = Task::query()
            ->where('id', 1)
            ->first();

        $data = [
            'task' => [
                'name' => 'New Task',
                'user_id' => 2,
                'status_id' => 2
            ],
        ];

        $screen = new TaskEditScreen();
        $screen->task = $task;

        $request = Request::create(route('platform.task.edit', $task), 'PATCH', $data);
        $response = $screen->update($request);

        $this->assertEquals(302, $response->status());

        $this
            ->assertDatabaseMissing('tasks', [
                'id' => 1,
                'name' => 'Correct an error in some string',
                'user_id' => 6,
                'status_id' => 1
            ])
            ->assertDatabaseHas('tasks', [
                'id' => 1,
                'name' => 'New Task',
                'user_id' => 2,
                'status_id' => 2
            ]);
    }
}
