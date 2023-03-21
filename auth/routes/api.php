<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Auth
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signin', [AuthController::class, 'signin']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('myaccount', [AuthController::class, 'getAuth']);

});

//Task
Route::prefix('task')->group(function () {
    Route::post('add', [TaskController::class, 'add']);
    Route::put('update/{UUID}', [TaskController::class, 'updateBy']);
    Route::get('find/all', [TaskController::class, 'findAll']);
    Route::get('find/{UUID}', [TaskController::class, 'findBy']);
    Route::delete('remove/{UUID}', [TaskController::class, 'delBy']);
});

//User
Route::prefix('user')->group(function () {
    Route::post('add', [UserController::class, 'addUser']);
    Route::delete('del/{UUID}', [UserController::class, 'delUserBy']);
    Route::put('update/{UUID}', [UserController::class, 'updateUserBy']);
    Route::get('find/all', [UserController::class, 'findAll']);
    Route::get('find/{UUID}', [UserController::class, 'findUserBy']);
});

