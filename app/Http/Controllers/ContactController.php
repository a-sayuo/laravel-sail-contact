<?php

namespace App\Http\Controllers;

use App\Models\Contact;      // お問い合わせモデル（DBとやりとりする）
use App\Models\Category; 
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    // ユーザー側：フォーム表示
    public function create()
    {
        $categories = Category::all();
        return view('contacts.create', compact('categories'));
    }

    // ユーザー側：送信処理
    public function store(StoreContactRequest $request)
    {
        // DBに保存
        Contact::create($request->validated());

        // ログインが必要な /contacts ではなく、誰でも見れる /contact に戻す
        return redirect('/contact')->with('success','お問い合わせを送信しました。ありがとうございます！');
    }

    // 管理側：一覧表示
    public function index()
    {
        $contacts = Contact::latest()->paginate(10); //最新順に取得（10ずつ）
        return view('contacts.index', compact('contacts'));
        // contacts/index.blade.php に $contacts を渡して表示
    }

    // 管理側：編集画面（詳細＋編集）
    public function edit($id)
    {
        $contact = Contact::findOrFail($id); // IDで検索、なければ404
        $categories = Category::all();
        $users = \App\Models\User::all();
        return view('contacts.edit', compact('contact', 'categories', 'users'));
        // contacts/edit.blade.php に $contact を渡して表示
    }

    // 管理側：更新処理
    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id); // IDで検索
        $contact->update($request->validated());

        return redirect('/contacts')->with('success','お問合せを更新しました！'); // 一覧へ戻る
    }

    // 管理側：削除処理
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id); // IDで検索
        $contact->delete();                  // 削除
        return redirect('/contacts');        // 一覧へ戻る
    }
}
