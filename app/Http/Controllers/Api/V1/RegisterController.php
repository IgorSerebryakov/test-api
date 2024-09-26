<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Base\Resources\ErrorResource;
use App\Modules\Security\DTO\RegisterDTO;
use App\Modules\Security\DTO\UserDTO;
use App\Modules\Security\Requests\RegisterRequest;
use App\Modules\Security\Resources\RegisterResource;
use App\Modules\Security\Services\RegisterService;


/**
 * @OA\Post (
 *     path="/api/v1/register",
 *     summary="Register user",
 *     tags={"Register"},
 *     operationId="Register",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/RegisterResponse")
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad Request",
 *     ),
 *)
 *
 */
class RegisterController extends Controller
{
    public function __construct(
        public RegisterService $registerService
    ) {}

    public function register(RegisterRequest $request)
    {
        $registerDTO = new RegisterDTO(
            name: $request->name,
            password: $request->password,
            email: $request->email
        );

        try {
            $this->registerService->register($registerDTO);
        } catch (\Exception $exception) {
            return new ErrorResource($exception);
        }

        return response()->json([
            'message' => 'Registration was successful'
        ], 200);
    }
}
