<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlanoController;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//cliente --------------------------------------------------------------------------------------------------------------------
Route::get('/clientes', [ClienteController::class, 'index']);
Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes/{id}', [ClienteController::class, 'show']);
Route::put('/clientes/{id}', [ClienteController::class, 'update']);
Route::delete('/clientes', [ClienteController::class, 'destroy']);

//login
Route::post('/login', [AuthController::class, 'login']);

//produto -----------------------------------------------------------------------------------------------------------------------------
// Rota para listar todos os produtos
Route::get('/produtos', [ProdutoController::class, 'index']);
//criar um novo produto
Route::post('/produtos', [ProdutoController::class, 'create']);
//exibe um produto específico pelo ID
Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
//deletar um produto específico pelo ID
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);



//categoria---------------------------------------------------------------------------------------------------------------------------------
Route::get('/categoria', [CategoriaController::class, 'index']);
Route::post('/categoria', [CategoriaController::class, 'create']);
Route::get('/categoria/{id}', [CategoriaController::class, 'show']);
Route::put('/categoria/{id}', [CategoriaController::class, 'update']);
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy']);



Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});



//plano
Route::get('/plano', [PlanoController::class, 'index']);
Route::post('/plano', [PlanoController::class, 'create']);
Route::get('/plano/{id}', [PlanoController::class, 'show']);
Route::put('/plano/{id}', [PlanoController::class, 'update']);
Route::delete('/plano/{id}', [PlanoController::class, 'destroy']);


