<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ClienteService;
use App\Services\UserService;
use App\Models\User;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get a list of all users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="email", type="string")
     *         ))
     *     )
     * )
     */

    public function index()
    {
        return $this->userService->index();
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get a specific user by ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */

    public function show($id)
    {
        try {
            $user = $this->userService->show($id);
            return response()->json($user);
        } catch (\Exception $e) {
            Log::error('user não encontrado:', ['id' => $id, 'message' => $e->getMessage()]);
            return response()->json(['message' => 'user não encontrado'], 404);
        }
    }


}
