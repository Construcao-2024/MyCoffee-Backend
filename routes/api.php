<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlanoController;
use App\http\Controllers\CargoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Middleware\CheckPermission;
use App\Models\Categoria;
use App\Services\FuncionarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//cliente --------------------------------------------------------------------------------------------------------------------
Route::get('/clientes', [ClienteController::class, 'index']);
Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes/{id}', [ClienteController::class, 'show']);
Route::put('/clientes/{id}', [ClienteController::class, 'update']);
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->middleware('permission:funcionario');



//login
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');


//
/*Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});*/


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



//cargo
Route::get('/cargo', [CargoController::class, 'index']);
Route::post('/cargo', [CargoController::class, 'create']);
Route::get('/cargo/{id}', [CargoController::class, 'show']);
Route::put('/cargo/{id}', [CargoController::class, 'update']);
Route::delete('/cargo/{id}', [CargoController::class, 'destroy']);



//funcionario
Route::get('/funcionario', [FuncionarioController::class, 'index']);
Route::post('/funcionario', [FuncionarioController::class, 'create']);
Route::get('/funcionario/{id}', [FuncionarioController::class, 'show']);
Route::put('/funcionario/{id}', [FuncionarioController::class, 'update']);
Route::delete('/funcionario/{id}', [FuncionarioController::class, 'destroy']);

