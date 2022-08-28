<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//group api routes
Route::get('groups', [GroupController::class, 'index']);
Route::get('groups/{id}', [GroupController::class, 'show']);
Route::post('groups', [GroupController::class, 'store']);
Route::put('groups/{id}', [GroupController::class, 'update']);
Route::delete('groups/{id}', [GroupController::class, 'destroy']);
Route::post('groups/attach_user', [GroupController::class, 'attachUser']);
Route::post('groups/detach_user', [GroupController::class, 'detachUser']);

//user api routes
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);
Route::put('users/groups/{id}', [UserController::class, 'syncGroups']);
Route::post('users/filters', [UserController::class, 'userFilters']);
