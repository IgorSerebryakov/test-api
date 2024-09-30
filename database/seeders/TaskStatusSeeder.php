<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Yaml\Yaml;

class TaskStatusSeeder extends Seeder
{

    public function run(): void
    {
        $statuses = Yaml::parseFile(__DIR__ . '/../fixtures/taskStatuses.yaml');

        TaskStatus::factory()
            ->count(count($statuses))
            ->sequence(...$statuses)
            ->create();
    }
}
