<?php

use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TrashedTodoController;
use App\Services\TestService;
use Spatie\Permission\Contracts\Permission;

use App\Http\Traits\TodoTrait;

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
 * Todo : Create a global scope that grabs the aut title
 */
// Route::group(['middleware' => 'auth:sanctum'], function () {
Route::group([], function () {
    Route::group(['middleware' => 'role:user|active'], function () {
        Route::apiResources([
            '/todos' => TodoController::class,
            '/tags' => TagController::class,
        ]);
    });

    Route::group([], function () {
        Route::apiResource('/status', StatusController::class);
        Route::apiResource('/trashed', TrashedTodoController::class, ['except' => ['store']]);
        Route::apiResource('/bans', BanController::class, ['only' => ['index', 'store', 'destroy']]);
    });

    Route::post('/test', TestController::class);
});

