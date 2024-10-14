<?php

namespace Tests\Feature;

use App\Mail\UncompletedTasks;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\TaskStatusSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TaskStatusTestCase;
use Tests\TestCase;

class SendUncompletedTasksTest extends TaskStatusTestCase
{
    public function testUsersReceiveEmailsWithUncompletedTasks(): void
    {
        Mail::fake();

        $users = User::factory()
            ->count(2)
            ->create();

        Task::factory()
            ->count(6)
            ->state(new Sequence(
                ['user_id' => 1],
                ['user_id' => 2]
            ))
            ->state(new Sequence(
                ['status_id' => 1],
                ['status_id' => 1],
                ['status_id' => 2],
                ['status_id' => 2],
                ['status_id' => 3],
                ['status_id' => 3]
            ))
            ->create();

        $this->artisan('send:uncompleted-tasks')
            ->assertExitCode(0);

        Mail::assertSent(UncompletedTasks::class, 2);
        Mail::assertSent(UncompletedTasks::class, function (UncompletedTasks $mail) use ($users) {
            foreach ($users as $user) {
                return $mail->hasTo($user->email) &&
                    $mail->hasFrom('TestAPI@api.com') &&
                    $mail->subject('Tasks From TestAPI');
            }
        });
    }

    public function testUsersNotReceiveEmailsWithCompletedTasks(): void
    {
        Mail::fake();

        User::factory()
            ->count(2)
            ->create();

        Task::factory()
            ->count(6)
            ->state(new Sequence(
                ['user_id' => 1],
                ['user_id' => 2]
            ))
            ->state(new Sequence(
                ['status_id' => 3],
                ['status_id' => 3],
                ['status_id' => 3],
                ['status_id' => 3]
            ))
            ->create();

        $this->artisan('send:uncompleted-tasks')
            ->assertExitCode(0);

        Mail::assertNothingSent();
    }
}
