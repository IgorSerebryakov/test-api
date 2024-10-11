<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TaskStatusSeeder::class,
            UserSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
