<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        Log::info('Tentativa de login com as seguintes credenciais: ' . json_encode($credentials));


        if (Auth::attempt($credentials)) {
            $user = User::find(Auth::id());

            if ($user) {
                Log::info('Usuário encontrado com sucesso: ' . $user->email);
            } else {
                Log::warning('Usuário não encontrado após autenticação.');
            }
            
            $token = $user->createToken('MyAppToken')->plainTextToken;
            Log::info('Usuário autenticado com sucesso: ' . $user->email);
            //return response()->json(['ok' => 'authorized'], 200);
            return response()->json(['token' => $token]);
        }

        else{
            Log::warning('Tentativa de login falhou para o email: ' . $credentials['email']);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        
    }

    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
