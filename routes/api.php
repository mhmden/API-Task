<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TrashedTodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Todo [] todo tag -> for filtering.
// Todo [] Assign Todo to any users
// Todo [] Todo Status Todo_Status ID
// Todo [] Todo Status History


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware(['auth:sanctum']);
});


// Extend this api resource I guess. 
Route::middleware(['auth:sanctum'])->group(function () {  
    Route::apiResource('todos', TodoController::class);
    Route::apiResource('trashed/todos', TrashedTodoController::class)->only([
        'index', 'update', 'destroy'
    ]);
});
