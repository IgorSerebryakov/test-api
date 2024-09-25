<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\TaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskDeleteRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TaskCollection(Task::query()->with('user')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $dto = new TaskDTO(
            id: null,
            name: $request->name,
            statusId: $request->status_id,
            userId: Auth::id()
        );

        $task = $this->taskService->createOrUpdate($dto);
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource(Task::query()->with('user')->find($task->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request)
    {
        $dto = new TaskDTO(
            id: $request->id,
            name: $request->name,
            statusId: $request->status_id,
            userId: Auth::id()
        );

        $task = $this->taskService->createOrUpdate($dto);
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskDeleteRequest $request)
    {
        try {
            $task = Task::query()->find($request->id);
            if (empty($task)) {
                throw new \DomainException('Task is not found.');
            }
        } catch (\Exception $exception) {
            return new ErrorResource($exception);
        }

        $task->delete();
        return new SuccessResource(null);
    }
}
