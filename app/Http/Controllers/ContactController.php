<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // フォーム表示
    public function create()
    {
        return view('contact.create');
    }

    // 保存処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Contact::create($validated);

        return redirect('/contacts')->with('success', 'お問い合わせを受け付けました！');
    }

    // 一覧表示
    public function index()
    {
        $contacts = Contact::all();
        return view('contact.index', compact('contacts'));
    }

    // 編集画面
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact.edit', compact('contact'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($validated);

        return redirect('/contacts')->with('success', '更新しました！');
    }

    // 削除処理
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect('/contacts')->with('success', '削除しました！');
    }
}