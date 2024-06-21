<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json(['token' => $token]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not create token', 'message' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            return response()->json(['message' => 'Logged out successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not log out', 'message' => $e->getMessage()], 500);
        }
    }
}
