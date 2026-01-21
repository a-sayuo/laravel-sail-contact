<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // フォーム送信データを受け取るためのクラス
use App\Models\Contact;      // お問い合わせモデル（DBとやりとりする）

class ContactController extends Controller
{
    // ユーザー側：フォーム表示
    public function create()
    {
        return view('contacts.create');
        // resources/views/contacts/create.blade.php を表示
    }

    // ユーザー側：送信処理
    public function store(Request $request)
    {
        // バリデーション（必須チェック）
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // DBに保存
        Contact::create($request->all());

        // 保存後に一覧画面へリダイレクト
        return redirect('/contacts');
    }

    // 管理側：一覧表示
    public function index()
    {
        $contacts = Contact::all(); // 全件取得
        return view('contacts.index', compact('contacts'));
        // contacts/index.blade.php に $contacts を渡して表示
    }

    // 管理側：編集画面（詳細＋編集）
    public function edit($id)
    {
        $contact = Contact::findOrFail($id); // IDで検索、なければ404
        return view('contacts.edit', compact('contact'));
        // contacts/edit.blade.php に $contact を渡して表示
    }

    // 管理側：更新処理
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id); // IDで検索
        $contact->update($request->all());   // 入力内容で更新
        return redirect('/contacts')->with('success', '更新しました！');// 一覧へ戻る
    }

    // 管理側：削除処理
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id); // IDで検索
        $contact->delete();                  // 削除
        return redirect('/contacts');        // 一覧へ戻る
    }
}
