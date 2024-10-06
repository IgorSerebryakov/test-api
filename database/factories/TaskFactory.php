<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->text(20),
            'status_id' => TaskStatus::query()->inRandomOrder()->first(),
            'user_id' => User::query()->inRandomOrder()->first(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
