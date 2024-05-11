<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClienteController::class, 'index']);
Route::post('/', [ClienteController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

//produto
Route::post('/produto', [ProdutoController::class, 'create']);

//categoria
Route::post('/categoria', [CategoriaController::class, 'create']);



Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

