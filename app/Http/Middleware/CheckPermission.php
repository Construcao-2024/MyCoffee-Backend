<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
{
     /** @var \App\Models\User $user */
    $user = Auth::user();
    dd($user);  // Depuração

    if ($user && $user->hasPermission($permission)) {
        return $next($request);
    }

    return response()->json(['error' => 'Unauthorized'], 403);
}
}
