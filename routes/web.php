<?php

use Illuminate\Support\Facades\Route; // ルーティング機能を使うためのクラス
use App\Http\Controllers\ContactController; // 作成するコントローラを読み込む

// ユーザー側：お問い合わせフォーム表示
Route::get('/contact', [ContactController::class, 'create']); 
// GET /contact にアクセスしたら ContactController の create() を呼ぶ

// ユーザー側：お問い合わせ送信（保存）
Route::post('/contact', [ContactController::class, 'store']); 
// POST /contact に送信されたら ContactController の store() を呼ぶ

// 管理側：一覧表示
Route::get('/contacts', [ContactController::class, 'index']); 
// GET /contacts にアクセスしたら ContactController の index() を呼ぶ

// 管理側：編集画面（詳細＋編集）
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit']); 
// GET /contacts/◯◯/edit にアクセスしたら ContactController の edit() を呼ぶ

// 管理側：更新処理
Route::put('/contacts/{id}', [ContactController::class, 'update']); 
// PUT /contacts/◯◯ に送信されたら ContactController の update() を呼ぶ

// 管理側：削除処理
Route::post('/contacts/{id}/delete', [ContactController::class, 'destroy']); 
// POST /contacts/◯◯/delete に送信されたら ContactController の destroy() を呼ぶ