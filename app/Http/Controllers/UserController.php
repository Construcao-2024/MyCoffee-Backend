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

    public function index()
    {
        return $this->userService->index();
    }

    
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
