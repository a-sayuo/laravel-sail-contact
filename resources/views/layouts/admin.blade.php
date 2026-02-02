<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eceff1;
        }
        .admin-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 2rem;
            max-width: 900px;
            margin: 3rem auto;
        }
        h1 {
            color: #37474f;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .btn-info {
            background-color: #adc5d1;
            border: none;
        }
        .btn-info:hover {
            background-color: #5d98b6;
        }
        .btn-danger {
            background-color: #e7b5b5;
            border: none;
        }
        .action-col {
            width: 120px;
            text-align: center;
            white-space: nowrap;
        }
    </style>
</head>
<body>

    {{-- ログイン中だけログアウトボタン --}}
    @auth
        <form method="POST" action="{{ route('logout') }}" style="text-align:right; margin:10px;">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    @endauth

    @yield('content')

</body>
</html>