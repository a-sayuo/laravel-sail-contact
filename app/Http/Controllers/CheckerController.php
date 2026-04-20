<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function index()
    {
        return view('checker');  // resources/views/checker.blade.php を表示
    }

    public function getData()
    {
        // 後でここでYouTubeやTwitchのAPIを呼び出して配信データを取得する処理を書く

        // 表示できることを確認
        return response()->json(['message' => 'APIからのデータをここに返す'

        ]);
    }
}
