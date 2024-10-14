<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Orchid\Screens\Task\TaskEditScreen;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TaskTestCase;
use Tests\TestCase;

class TaskCreateScreenTest extends TaskTestCase
{
    use ScreenTesting;

    public function testCreate(): void
    {
        $screen = new TaskEditScreen();
        $screen->task = new Task();

        $data = [
            'task' => [
                'name' => 'New Task',
                'user_id' => 1,
                'status_id' => 1
            ],
        ];

        $request = Request::create(route('platform.task.edit'), 'POST', $data);
        $response = $screen->create($request);

        $this->assertEquals(302, $response->status());

        $this->assertDatabaseHas('tasks', [
            'name' => 'New Task',
            'user_id' => 1,
            'status_id' => 1
        ]);
    }
}
