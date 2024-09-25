<?php

namespace App\Services;

use App\DTO\TaskStatusDTO;
use App\Models\TaskStatus;

class TaskStatusService
{
    public function createOrUpdate(TaskStatusDTO $dto): TaskStatus
    {
        $taskStatus = TaskStatus::query()
            ->find($dto->id);

        if (empty($taskStatus)) {
            $taskStatus = new TaskStatus();
        }

        $taskStatus->name = $dto->name;
        $taskStatus->save();

        return $taskStatus;
    }
}
