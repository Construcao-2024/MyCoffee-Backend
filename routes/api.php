<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClienteController::class, 'index']);
Route::post('/', [ClienteController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

