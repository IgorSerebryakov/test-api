<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Base\Resources\ErrorResource;
use App\Modules\Base\Resources\SuccessResource;
use App\Modules\Security\DTO\AuthDTO;
use App\Modules\Security\Requests\AuthRequest;
use App\Modules\Security\Resources\AuthResource;
use App\Modules\Security\Services\AuthService;


class AuthController extends Controller
{
    public function __construct(
        public AuthService $authService
    ) {}

    /**
     * @OA\Post (
     *     path="/api/v1/login",
     *     summary="User auth (by email)",
     *     tags={"Auth"},
     *     operationId="Login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *     ),
     *)
     *
     */
    public function login(AuthRequest $request)
    {
        $authDTO = new AuthDTO(
            login: $request->login,
            password: $request->password
        );

        try {
            $userDTO = $this->authService->login($authDTO);
        } catch (\Exception $exception) {
            return new ErrorResource($exception);
        }

        return new AuthResource($userDTO);
    }

    public function logout()
    {
        auth()->logout(true);
        return new SuccessResource(null);
    }

    public function refresh()
    {
        return response()->json(['token' => auth()->refresh()]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
