<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TaskStatus;
use App\Modules\Base\Resources\ErrorResource;
use App\Modules\Base\Resources\SuccessResource;
use App\Modules\TaskStatus\DTO\TaskStatusDTO;
use App\Modules\TaskStatus\Requests\StoreTaskStatusRequest;
use App\Modules\TaskStatus\Requests\TaskStatusDeleteRequest;
use App\Modules\TaskStatus\Requests\TaskStatusShowRequest;
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
     * @OA\Get(
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
     *)
     */
    public function index()
    {
        $taskStatuses = TaskStatus::query()->paginate();

        return new TaskStatusCollection($taskStatuses);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/task-statuses",
     *     summary="Create a TaskStatus",
     *     tags={"TaskStatus"},
     *     operationId="CreateTaskStatus",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskStatusRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskStatusResponse")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation Exception",
     *     ),
     *)
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
     * @OA\Get (
     *     path="/api/v1/auth/task-statuses/{task_status}",
     *     summary="Get a TaskStatus",
     *     tags={"TaskStatus"},
     *     operationId="TaskStatusShow",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         description="taskstatus id",
     *         in="path",
     *         name="task_status",
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResponse")
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="TaskStatus not found",
     *      ),
     *      @OA\Response(
     *           response="400",
     *           description="Validation exception"
     *       ),
     *)
     */
    public function show(TaskStatusShowRequest $request)
    {
        $taskStatus = TaskStatus::query()->find($request->id);

        return new TaskStatusResource($taskStatus);
    }

    /**
     * @OA\Patch (
     *     path="/api/v1/auth/task-statuses/{task_status}",
     *     summary="Update a TaskStatus",
     *     tags={"TaskStatus"},
     *     operationId="UpdateTaskStatus",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         description="taskstatus id",
     *         in="path",
     *         name="task_status",
     *         required=true,
     *         example=1
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskStatusRequest")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/UpdateTaskStatusResponse")
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *      ),
     *)
     */
    public function update(UpdateTaskStatusRequest $request)
    {
        $dto = new TaskStatusDTO(
            id: $request->id,
            name: $request->name
        );

        $taskStatus = $this->taskStatusService->createOrUpdate($dto);
        return new TaskStatusResource($taskStatus);
    }

    /**
     * @OA\Delete (
     *     path="/api/v1/auth/task-statuses/{task_status}",
     *     summary="Delete a TaskStatus",
     *     tags={"TaskStatus"},
     *     operationId="DeleteTaskStatus",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         description="taskstatus id",
     *         in="path",
     *         name="task_status",
     *         required=true,
     *         example=1
     *       ),
     *     @OA\Response(
     *         response="204",
     *         description="Successfully deleted",
     *         @OA\MediaType(
     *              mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Task not found",
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Validation exception"
     *      )
     *)
     */
    public function destroy(TaskStatusDeleteRequest $request)
    {
        $taskStatus = TaskStatus::query()->find($request->id);

        $taskStatus->delete();

        return response()->noContent();
    }
}
