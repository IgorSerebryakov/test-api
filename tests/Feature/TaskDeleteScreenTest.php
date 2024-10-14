<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Orchid\Screens\Task\TaskEditScreen;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TaskTestCase;
use Tests\TestCase;

class TaskDeleteScreenTest extends TaskTestCase
{
    use ScreenTesting;

    public function testDelete(): void
    {
        $task = Task::query()
            ->where('id', 1)
            ->first();

        $screen = new TaskEditScreen();
        $screen->task = $task;

        $response = $screen->delete();

        $this->assertEquals(302, $response->status());

        $this->assertDatabaseMissing('tasks', [
            'id' => 1,
            'name' => 'Correct an error in some string'
        ]);
    }
}
