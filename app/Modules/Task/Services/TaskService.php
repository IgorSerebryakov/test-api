<?php

namespace App\Modules\Task\Services;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Modules\Task\DTO\TaskDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskService
{
//    public function createOrUpdate(TaskDTO $dto): Task|JsonResponse
//    {
//        $task = Task::query()
//            ->find($dto->id);
//
//        if ($task->user->id !== Auth::id()) {
//            return response()->json([
//                'type' => 'error',
//                'message' => 'This task belongs to another user'
//            ], 403);
//        }
//
//        $status = TaskStatus::query()
//            ->where('name', $dto->status)
//            ->first() ??
//            TaskStatus::query()
//                ->firstOrCreate(['name' => 'Created']);
//
//        if (empty($task)) {
//            $task = new Task();
//            $task->user_id = $dto->userId;
//        }
//
//        $task->name = $dto->name;
//        $task->status_id = $status->id;
//        $task->save();
//
//        return $task;
//    }

    public function create(TaskDTO $dto): Task
    {
        $task = new Task();
        $status = TaskStatus::query()->firstOrCreate(['name' => 'Created']);

        $task->name = $dto->name;
        $task->user_id = $dto->userId;
        $task->status_id = $status->id;

        $task->save();

        return $task;
    }

    public function update(TaskDTO $dto): Task|JsonResponse
    {
        $task = Task::query()
            ->find($dto->id);

        if ($task->user->id !== Auth::id()) {
            throw new \Exception();
        }

        $status = TaskStatus::query()
            ->where('name', $dto->status)
            ->first();

        $task->name = $dto->name;
        $task->user_id = $dto->userId;
        $task->status_id = $status->id;

        $task->save();

        return $task;
    }
}
