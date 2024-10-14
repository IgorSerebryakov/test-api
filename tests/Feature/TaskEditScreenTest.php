<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TaskTestCase;
use Tests\TestCase;

class TaskEditScreenTest extends TaskTestCase
{
    use ScreenTesting;

    protected $seed = true;

    public function testTaskEditScreen(): void
    {
        $user = User::factory()->admin()->create();

        $task = Task::query()
            ->where('id', 1)
            ->first();

        $screen = $this
            ->screen('platform.task.edit', [$task])
            ->actingAs($user, 'web');

        $screen->display()
            ->assertOk()
            ->assertSee('Edit task')
            ->assertSee('Update')
            ->assertSee('Remove')
            ->assertSee('Title')
            ->assertSee('Author')
            ->assertSee('Status')
            ->assertSee($task->name)
            ->assertSee($task->user->name)
            ->assertSee($task->status->name);
    }
}
