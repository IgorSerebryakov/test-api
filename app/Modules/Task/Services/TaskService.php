<?php

namespace App\Modules\Task\Services;

use App\Models\Task;
use App\Modules\Task\DTO\TaskDTO;

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
