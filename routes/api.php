<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Создание пользователя
Route::post('/register', [UserController::class, 'register']);

// Авторизация пользователя
Route::post('/auth', [UserController::class, 'auth']);

// Запросы только для авторизованного пользователя
Route::middleware(['auth:sanctum'])->group(function () {
    // Получение информации о пользователе
    Route::get('/user', [UserController::class, 'info']);

    // Обновление информации о пользователе
    Route::put('/user', [UserController::class, 'update']);

    // Удаление пользователя
    Route::delete('/user', [UserController::class, 'delete']);
});
