<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Yaml\Yaml;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Yaml::parseFile(__DIR__ . '/../fixtures/tasks.yml');

        $user = User::factory()->create([
            'name' => 'Igor',
            'email' => 'serebryakov09@mail.ru'
        ]);

        Task::factory()
            ->count(count($tasks))
            ->sequence(...$tasks)
            ->for($user)
            ->state(new Sequence(
                ['status_id' => 1],
                ['status_id' => 2],
                ['status_id' => 3]
            ))
            ->create();
    }
}
