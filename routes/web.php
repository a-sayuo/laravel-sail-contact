<?php

use Illuminate\Support\Facades\Route; // ルーティング機能を使うためのクラス
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\CheckerController;

Route::get('/debug-form', function() {
    return 'ログインなしで見れるページです！';
});

//強制的に/contactsへリダイレクト
Route::get('/', fn() => redirect('/contacts'));

// ユーザー側：お問い合わせフォーム表示
Route::get('/contact', [ContactController::class, 'create']); 
// GET /contact にアクセスしたら ContactController の create() を呼ぶ

// ユーザー側：お問い合わせ送信（保存）
Route::post('/contact', [ContactController::class, 'store']); 
// POST /contact に送信されたら ContactController の store() を呼ぶ

//配信チェッカーページ表示用
    Route::get('/checker', [CheckerController::class, 'index']);
//APIデータ取得用
    Route::get('/checker/api', [CheckerController::class, 'getData']);

// 管理側（ログイン必須）
Route::middleware(['auth'])->group(function () {

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

    // 管理側：カテゴリー一覧表示
    Route::resource('categories', CategoryController::class); 
    // GET /categories にアクセスしたら CategoryController の index() を呼ぶ

    //管理側：メモの保存実行
    Route::post('/memos', [MemoController::class, 'store']);
    // POST /memos に送信されたら MemoController の store() を呼ぶ
});