<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/test-logging', function () {
    Log::info('This is a test log message for Graylog.');
    return 'Log message sent!';
});

// require __DIR__.'/auth.php';
