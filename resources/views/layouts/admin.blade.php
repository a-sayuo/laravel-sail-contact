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
        .btn-primary {
        background-color: #90a4ae;
        border: none;
        }
        .btn-primary:hover {
        background-color: #607d8b;
        }
        /* ページネーション カスタムカラー */
        .pagination .page-link {
            color: #546e7a;
            border-color: #cfd8dc;
        }
        .pagination .page-item.active .page-link {
            background-color: #546e7a;
            border-color: #546e7a;
            color: #fff;
        }
        .pagination .page-link:hover {
            background-color: #cfd8dc;
            color: #37474f;
        }
    </style>
</head>
<body>

    {{-- ログイン中だけログアウトボタン --}}
    @auth
        <nav style="background-color: #546e7a; padding: 0.75rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            
            {{-- 左側：ページリンク --}}
            <div style="display: flex; gap: 1rem;">
                <a href="/contacts"
                   style="color: {{ request()->is('contacts*') ? '#fff' : '#cfd8dc' }};
                          text-decoration: none;
                          font-weight: {{ request()->is('contacts*') ? 'bold' : 'normal' }};">
                    お問い合わせ一覧
                </a>
                <a href="/categories"
                   style="color: {{ request()->is('categories*') ? '#fff' : '#cfd8dc' }};
                          text-decoration: none;
                          font-weight: {{ request()->is('categories*') ? 'bold' : 'normal' }};">
                    カテゴリ管理
                </a>
            </div>
    
            {{-- 右側：ログアウト --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="background: none; border: 1px solid #cfd8dc; color: #fff; padding: 0.25rem 0.75rem; border-radius: 4px; cursor: pointer;">
                    ログアウト
                </button>
            </form>
    
        </nav>
    @endauth

    @yield('content')

</body>
</html>