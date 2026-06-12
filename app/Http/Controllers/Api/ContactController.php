<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with(['category', 'assignedUser'])
            ->latest()
            ->paginate(10);

        return response()->json($contacts);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id); //IDでデータを検索取得
        $contact->delete();

        return response()->json(['message' => '削除しました']);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id); //IDでデータを検索取得
        $contact->update($request->only([
            'name',
            'email',
            'message',
            'prefecture',
            'city',
            'category_id',
            'assigned_user_id',
        ]));

        // 次に画面を読み込んだ時にも正しく表示できるよう、
        // リレーション（担当者とカテゴリのデータ）を最新の状態に読み込み直してReactに返す
        $contact->load(['category', 'assignedUser']);

        return response()->json($contact);
    }
}
