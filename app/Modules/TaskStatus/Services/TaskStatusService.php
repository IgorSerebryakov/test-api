<?php

namespace App\Modules\TaskStatus\Services;

use App\Models\TaskStatus;
use App\Modules\TaskStatus\DTO\TaskStatusDTO;

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
