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

        $statusId = TaskStatus::query()
            ->where('name', $dto->status)
            ->value('id');

        if (empty($task)) {
            $task = new Task();
            $task->user_id = $dto->userId;
        }

        $task->name = $dto->name;
        $task->status_id = $statusId;
        $task->save();

        return $task;
    }
}
