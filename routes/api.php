<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TrashedTodoController;
use App\Http\Controllers\StatusController;

use App\Models\User;
use App\Models\Todo;
use App\Models\Status;

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

// Todo [X] Todo / User Many to Many -> Attach a single todo to multiple users. Basically, the body from this point on will be json
// Todo [X] todo tag -> for filtering. Todo:M ------------ M: Tag 
// Todo [X] Fix the attach method.
// Todo [X] Todo Status Todo_Status ID. Todo:M ------------- 1:Status


// Todo [] Todo Status  changes. Todo: 1 ------------------ M:Changes


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware(['auth:sanctum']);
});

// Remember the URI does not matter. The Controller name is what does.
Route::middleware([])->group(function () { // ? Middleware not enabled because of testing
    Route::apiResource('/todos', TodoController::class);
    Route::apiResource('/tags', TagController::class)->only(['index', 'store', 'show']);
    Route::apiResource('/status', StatusController::class)->only(['index', 'store', 'show']);
    Route::apiResource('/trashed', TrashedTodoController::class)->only([
        'index', 'update', 'destroy'
    ]);
});
