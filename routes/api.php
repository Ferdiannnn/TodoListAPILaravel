<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::get('/todos',[TodoController::class,'index'])->middleware(['auth:sanctum','throttle:api']);
Route::post('/todos',[TodoController::class,'store'])->middleware('auth:sanctum');
Route::put('/todos/{id}',[TodoController::class,'update'])->middleware('auth:sanctum');
Route::delete('/todos/{id}',[TodoController::class,'destroy'])->middleware('auth:sanctum');

