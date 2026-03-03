<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <style>
        * {
        box-sizing: border-box;
    }
    
        body {
            font-family: sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            width: 90%;              /* 画面幅の90%を使う（スマホでも余白ができる） */
            max-width: 350px;        /* 最大幅を350pxにして「半分くらいのサイズ」に */
            margin: 40px auto;       /* 中央寄せ */
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            display: block;
            margin: 20px auto 0;
            padding: 8px 16px;
            width: 60%;              /* ボタンの幅を小さく */
            max-width: 200px;        /* 大きくなりすぎないように */
            background: #89cf8b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #45a049;
        }
        .btn-center {
            display: block;
            width: fit-content;
            margin: 0 auto 20px;
            background: #89cf8b;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-center:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    {{ auth()->check() ? 'ログイン中' : '未ログイン' }}
    
    {{-- ログインしている時だけ表示 --}}
    @auth
        <form method="POST" action="{{ route('logout') }}" style="text-align:right; margin:10px;">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    @endauth

    <div class="container">
        @yield('content')
    </div>
</body>
</html>