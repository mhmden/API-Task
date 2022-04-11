<?php

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\StatusController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/forgot-password', 'recover');
    Route::post('/reset-password', 'reset');
    Route::post('/logout', 'logout')->middleware(['auth:sanctum']);
});

/** 
 * Todo [X] Cruddy BanController 
 * Todo [X] Create Validation for Auth Controller
 * Todo [X] Ban Index
 * Todo [X] Check if User is active via Middleware
 * Todo [X] Upload an attachment / Attachments for a Todo
 * Todo [] Filter The Todos Based on any field.
 * 
 */
Route::middleware(['auth:sanctum', 'active'])->group(function () {
    Route::apiResources([
        '/todos' => TodoController::class,
        '/tags' => TagController::class,
        '/status' => StatusController::class,
    ]);
    Route::apiResource('/banned-users', BanController::class)->only('index','update', 'destroy');
    Route::apiResource('/trashed', TrashedTodoController::class)->except('store');
});