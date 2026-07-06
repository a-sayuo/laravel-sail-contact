<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;

//認証が必要なAPIルート（Sanctum）
Route::middleware('auth:sanctum')->group(function () {
    //ユーザー情報取得（useAuthフックで使う）
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    Route::get('/contacts', [ContactController::class, 'index']);
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
    Route::put('/contacts/{id}', [ContactController::class, 'update']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);
});
