<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TrashedTodoController;
use App\Http\Controllers\StatusController;
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
    Route::post('/logout', 'logout')->middleware(['auth:sanctum']);
});

Route::middleware([])->group(function () {
    /** 
     * TODO response with message and http code [X] For TodoController Only 
     * TODO remove any redundant resources|collections
    */

    Route::apiResources([
        '/todos' => TodoController::class,
        '/tags' => TagController::class,
        '/status' => StatusController::class,
    ]);
    Route::apiResource('/trashed', TrashedTodoController::class)->except('store'); // No use for store method
});


/**
 * * Status Codes are as follows:
 * ? - Index / Show -> 200
 * ? - Store 201
 * ? - Update / Delete 204
 */

 // Todo [] Macro for Responses, and Error Codes
// Todo [] Console Output