<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        Log::info('User:', ['user' => $user]);  // Depuração

        if ($user && $user->hasPermission($permission)) {
            Log::info('Permission check passed:', ['permission' => $permission]);  // Depuração
            return $next($request);
        }

        Log::warning('Unauthorized access attempt:', ['user' => $user, 'permission' => $permission]);  // Depuração
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
