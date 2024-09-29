<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Modules\Base\Resources\ErrorResource;
use App\Modules\Base\Resources\SuccessResource;
use App\Modules\Task\DTO\TaskDTO;
use App\Modules\Task\Requests\StoreTaskRequest;
use App\Modules\Task\Requests\TaskDeleteRequest;
use App\Modules\Task\Requests\TaskShowRequest;
use App\Modules\Task\Requests\UpdateTaskRequest;
use App\Modules\Task\Resources\TaskCollection;
use App\Modules\Task\Resources\TaskResource;
use App\Modules\Task\Services\TaskService;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/auth/tasks",
     *     summary="Get all user's tasks",
     *     tags={"Task"},
     *     operationId="TaskList",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/TasksResponse")
     *     ),
     *)
     */
    public function index()
    {
        return new TaskCollection(Task::query()->with('user')->paginate());
    }

    /**
     * @OA\Post (
     *     path="/api/v1/auth/tasks",
     *     summary="Create a new task",
     *     tags={"Task"},
     *     operationId="CreateTask",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskResponse")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation exception"
     *     )
     *)
     */
    public function store(StoreTaskRequest $request)
    {
        $dto = new TaskDTO(
            id: null,
            name: $request->name,
            status: $request->status,
            userId: Auth::id()
        );

        $task = $this->taskService->createOrUpdate($dto);
        return new TaskResource($task);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/auth/tasks/{task}",
     *     summary="Get user's task",
     *     tags={"Task"},
     *     operationId="TaskShow",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         description="task's id",
     *         in="path",
     *         name="task",
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResponse")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Task not found",
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Validation exception"
     *      ),
     *)
     */
    public function show(TaskShowRequest $request)
    {
        $task = Task::query()
            ->where('id', $request->id)
            ->where('user_id', Auth::id())
            ->first();

        return new TaskResource($task);
    }

    /**
     * @OA\Patch (
     *     path="/api/v1/auth/tasks/{task}",
     *     summary="Update user's task",
     *     tags={"Task"},
     *     operationId="UpdateTask",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *          description="task's id",
     *          in="path",
     *          name="task",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskResponse")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Task not found",
     *      ),
     *      @OA\Response(
     *           response="400",
     *           description="Validation exception"
     *       ),
     *)
     */
    public function update(UpdateTaskRequest $request)
    {
        $dto = new TaskDTO(
            id: $request->id,
            name: $request->name,
            status: $request->status,
            userId: Auth::id()
        );

        $task = $this->taskService->createOrUpdate($dto);
        return new TaskResource($task);
    }

    /**
     * @OA\Delete (
     *     path="/api/v1/auth/tasks/{task}",
     *     summary="Delete user's task",
     *     tags={"Task"},
     *     operationId="DeleteTask",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *          description="task's id",
     *          in="path",
     *          name="task",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *         response="204",
     *         description="Successfully deleted",
     *         @OA\MediaType(
     *               mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Task not found",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation exception"
     *     )
     *)
     */
    public function destroy(TaskDeleteRequest $request)
    {
        $task = Task::query()
            ->where('id', $request->id)
            ->where('user_id', Auth::id())
            ->first();

        $task->delete();

        return response()->noContent();
    }
}
