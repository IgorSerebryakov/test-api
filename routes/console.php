<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schedule;

Schedule::command('send:uncompleted-tasks')
    ->cron(Cache::get('tasks_uncompleted_cron'));
