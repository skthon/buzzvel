<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::group([], function() {
    Route::post('/register',[AuthController::class, 'register'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware('auth:sanctum')->apiResource('tasks', 'V1\Controllers\TaskController');
