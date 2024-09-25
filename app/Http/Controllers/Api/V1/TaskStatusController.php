<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\TaskStatusDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\TaskStatusDeleteRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TaskStatusCollection;
use App\Http\Resources\TaskStatusResource;
use App\Models\TaskStatus;
use App\Services\TaskStatusService;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __construct(
        protected TaskStatusService $taskStatusService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::query()->paginate();

        return new TaskStatusCollection($taskStatuses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskStatusRequest $request)
    {
        $dto = new TaskStatusDTO(
            id: null,
            name: $request->name
        );

        $taskStatus = $this->taskStatusService->createOrUpdate($dto);
        return new TaskStatusResource($taskStatus);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        return new TaskStatusResource($taskStatus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $dto = new TaskStatusDTO(
            id: $request->id,
            name: $request->name
        );

        $taskStatus = $this->taskStatusService->createOrUpdate($dto);
        return new TaskStatusResource($taskStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatusDeleteRequest $request)
    {
        try {
            $taskStatus = TaskStatus::query()->find($request->id);
            if (empty($taskStatus)) {
                throw new \DomainException('Status is not found.');
            }
        } catch (\Exception $exception) {
            return new ErrorResource($exception);
        }

        $taskStatus->delete();
        return new SuccessResource(null);
    }
}
