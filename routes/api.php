<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group([
        'middleware' => ['api', 'auth'],
        'prefix' => 'auth'
    ], function () {
        Route::post('/me', [AuthController::class, 'me'])->name('user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('user.token.refresh');

        Route::apiResource('tasks', TaskController::class);
        Route::apiResource('task-statuses', TaskStatusController::class);
    });

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});
