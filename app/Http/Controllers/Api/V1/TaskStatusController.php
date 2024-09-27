<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TaskStatus;
use App\Modules\Base\Resources\ErrorResource;
use App\Modules\Base\Resources\SuccessResource;
use App\Modules\TaskStatus\DTO\TaskStatusDTO;
use App\Modules\TaskStatus\Requests\StoreTaskStatusRequest;
use App\Modules\TaskStatus\Requests\TaskStatusDeleteRequest;
use App\Modules\TaskStatus\Requests\UpdateTaskStatusRequest;
use App\Modules\TaskStatus\Resources\TaskStatusCollection;
use App\Modules\TaskStatus\Resources\TaskStatusResource;
use App\Modules\TaskStatus\Services\TaskStatusService;

class TaskStatusController extends Controller
{
    public function __construct(
        protected TaskStatusService $taskStatusService
    ) {}

    /**
     * @OA\Get (
     *     path="/api/v1/auth/task-statuses",
     *     summary="Get all TaskStatuses",
     *     tags={"TaskStatus"},
     *     operationId="TaskStatusList",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/TaskStatusesResponse")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *     ),
     *)
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
