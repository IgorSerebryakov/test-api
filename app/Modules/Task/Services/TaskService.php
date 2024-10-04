<?php

namespace App\Modules\Task\Services;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Modules\Task\DTO\TaskDTO;

class TaskService
{
    public function createOrUpdate(TaskDTO $dto): Task
    {
        $task = Task::query()
            ->find($dto->id);

        $status = TaskStatus::query()
            ->where('name', $dto->status)
            ->first() ??
            TaskStatus::query()
                ->firstOrCreate(['name' => 'Created']);

        if (empty($task)) {
            $task = new Task();
            $task->user_id = $dto->userId;
        }

        $task->name = $dto->name;
        $task->status_id = $status->id;
        $task->save();

        return $task;
    }
}
