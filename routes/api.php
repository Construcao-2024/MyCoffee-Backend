<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClienteController::class, 'index']);
Route::post('/', [ClienteController::class, 'store']);
