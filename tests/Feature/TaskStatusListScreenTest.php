<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use App\Orchid\Screens\TaskStatus\TaskStatusListScreen;
use Database\Seeders\TaskStatusSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TestCase;

class TaskStatusListScreenTest extends TestCase
{
    use ScreenTesting;

    protected $seeder = TaskStatusSeeder::class;

    public function testTaskStatusListScreen(): void
    {
        $user = User::factory()->admin()->create();

        $screen = $this
            ->screen('platform.task-status.list')
            ->actingAs($user, 'web');

        $screen->display()
            ->assertOk()
            ->assertSee('Task Statuses')
            ->assertSee('All task statuses')
            ->assertSee('Create new')
            ->assertSee('Created')
            ->assertSee('In process')
            ->assertSee('Completed');

        $response = $this->get(route('platform.task-status.edit'));

        $response->assertOk();
        $response->assertSee('Creating a new task');
    }

    public function testCommandBarCreateLink(): void
    {
        $screen = new TaskStatusListScreen();
        $commandBar = $screen->commandBar();
        $link = $commandBar[0];

        $this->assertInstanceOf(Link::class, $link);
        $this->assertEquals(route('platform.task-status.edit'), $link->get('href'));
    }

    public function testLinkToEditStatus(): void
    {
        $user = User::factory()->admin()->create();

        $this
            ->screen('platform.task-status.list')
            ->actingAs($user, 'web');

        $status = TaskStatus::query()
            ->where('name', 'Created')
            ->first();

        $statusUrl = route('platform.task-status.edit', $status);

        $response = $this->get($statusUrl);

        $response->assertOk();
        $response->assertSee('Edit task status');
    }
}
