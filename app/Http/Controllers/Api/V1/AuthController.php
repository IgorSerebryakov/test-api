<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Base\Resources\ErrorResource;
use App\Modules\Base\Resources\SuccessResource;
use App\Modules\Security\DTO\AuthDTO;
use App\Modules\Security\Requests\AuthRequest;
use App\Modules\Security\Resources\AuthResource;
use App\Modules\Security\Services\AuthService;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function __construct(
        public AuthService $authService
    ) {}

    /**
     * @OA\Post(
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

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     summary="User logout",
     *     tags={"Auth"},
     *     operationId="Logout",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *               mediaType="application/json"
     *          )
     *     )
     *)
     */
    public function logout()
    {
        auth()->logout(true);
        return new SuccessResource(null);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/refresh",
     *     summary="Refresh token",
     *     tags={"Auth"},
     *     operationId="Refresh",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/RefreshResponse"),
     *     ),
     *)
     */
    public function refresh()
    {
        return response()->json(['token' => auth()->refresh()]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/me",
     *     summary="Get auth user",
     *     tags={"Auth"},
     *     operationId="Me",
     *     security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/MeResponse")
     *      ),
     * )
     */
    public function me()
    {
        try {
            if (! JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(auth()->user());
    }
}
