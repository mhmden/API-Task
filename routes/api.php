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
 * Todo [X] Check if User is active via Middleware
 * Todo [X] Upload an attachment / Attachments for a Todo
 * Todo [X] Filter The Todos Based on any field.
 * Todo [X] Consider changing ban methods
 * Todo [X] Complete the Pipeline tutorial
 * Todo [X] Create Pipes to query about relationship existence -> Tags /  Status
 * Todo [X] Change System files so that. -> No need it can go in the second parameter
 * TODO [X] Change the store method, don't use folders, and let it be hashed
 */
Route::middleware(['auth:sanctum', 'active'])->group(function () {
    Route::apiResources([
        '/todos' => TodoController::class,
        '/tags' => TagController::class,
        '/status' => StatusController::class,
    ]);
    Route::apiResource('/trashed', TrashedTodoController::class)->except('store');
    Route::apiResource('/bans', BanController::class)->only([
        'index', 'show', 'update'
    ]);
});

Route::post('/test', function (Request $request) {

    // * Hardcode the search for the tags method

    $todo = Todo::query();

    if (request()->has('tags')){
        $todo->has('tags');
    }

    $x = $todo->get();

    return response()->json($x);

});
