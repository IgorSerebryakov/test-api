<?php

namespace Tests;

use Database\Seeders\TaskStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TaskStatusTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(TaskStatusSeeder::class);
    }
}
