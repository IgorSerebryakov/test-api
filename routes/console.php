<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Predis\Client;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

$client = new Client('tcp://predis:6379');

Schedule::command('send:uncompleted-tasks')
    ->cron($client->get('tasks_uncompleted_cron'));
