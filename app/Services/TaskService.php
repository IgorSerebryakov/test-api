<?php

namespace App\Services;

use App\DTO\TaskDTO;
use App\Models\Task;

class TaskService
{
    public function createOrUpdate(TaskDTO $dto): Task
    {
        $task = Task::query()
            ->find($dto->id);

        if (empty($task)) {
            $task = new Task();
            $task->user_id = $dto->userId;
        }

        $task->name = $dto->name;
        $task->status_id = $dto->statusId;
        $task->save();

        return $task;
    }
}
