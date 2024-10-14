<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use App\Orchid\Screens\Task\TaskListScreen;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TaskTestCase;
use Tests\TestCase;

class TaskListScreenTest extends TaskTestCase
{
    use ScreenTesting;

    public function testTaskListScreen(): void
    {
        $user = User::factory()
            ->admin()
            ->create();

        $tasks = Task::query()
            ->paginate()
            ->items();

        $screen = $this
            ->screen('platform.task.list')
            ->actingAs($user, 'web');

        $screen->display()
            ->assertOk()
            ->assertSee('Tasks')
            ->assertSee('All tasks')
            ->assertSee('Create new');

        foreach ($tasks as $task) {
            $screen->display()
                ->assertSee($task->name)
                ->assertSee($task->created_at)
                ->assertSee($task->updated_at);
        }

        $response = $this->get(route('platform.task.edit'));

        $response
            ->assertOk()
            ->assertSee('Creating a new task')
            ->assertSee('Create')
            ->assertSee('Title')
            ->assertSee('Author')
            ->assertSee('Status');
    }

    public function testCommandBarCreateLink(): void
    {
        $screen = new TaskListScreen();
        $commandBar = $screen->commandBar();
        $link = $commandBar[0];

        $this->assertInstanceOf(Link::class, $link);
        $this->assertEquals(route('platform.task.edit'), $link->get('href'));
    }

    public function testLinkToEditTask(): void
    {
        $user = User::factory()->admin()->create();

        $this
            ->screen('platform.task.list')
            ->actingAs($user, 'web');

        $task = Task::query()
            ->where('name', 'Correct an error in some string')
            ->first();

        $taskUrl = route('platform.task.edit', $task);

        $response = $this->get($taskUrl);

        $response
            ->assertOk();
    }
}
