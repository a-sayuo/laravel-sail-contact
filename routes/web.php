<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// お問い合わせフォーム表示
Route::get('/contact', [ContactController::class, 'create']);

// お問い合わせ送信（保存）
Route::post('/contact', [ContactController::class, 'store']);

// 一覧表示
Route::get('/contacts', [ContactController::class, 'index']);

// 編集画面
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit']);

// 更新処理
Route::post('/contacts/{id}', [ContactController::class, 'update']);

// 削除処理
Route::post('/contacts/{id}/delete', [ContactController::class, 'destroy']);
