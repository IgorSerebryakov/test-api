<?php

namespace Tests\Feature;


use Database\Seeders\TaskStatusSeeder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Event;
use Tests\TaskStatusTestCase;
use Tests\TestCase;

class TaskScheduleTest extends TaskStatusTestCase
{
    public function testScheduleCronEqualsCronByCache()
    {
        Cache::shouldReceive('get')
            ->with('tasks_uncompleted_cron')
            ->andReturn('0 * * * *');

        $schedule = app(Schedule::class);

        $schedule->command('send:uncompleted-tasks')
            ->cron(Cache::get('tasks_uncompleted_cron'));

        $event = collect($schedule->events())->filter(function (\Illuminate\Console\Scheduling\Event $event) {
            return stripos($event->command, 'send:uncompleted-tasks');
        });

        $newEvent = $event->last();

        $this->assertNotNull($newEvent);
        $this->assertEquals('0 * * * *', $newEvent->expression);
    }
}
