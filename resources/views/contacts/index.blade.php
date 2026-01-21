<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eceff1; /* 落ち着いたブルーグレイ */
        }
        .admin-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 2rem;
            max-width: 900px;
            margin: 3rem auto; /* 中央寄せ */
        }
        h1 {
            color: #37474f; /* 濃いブルーグレイでアクセント */
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .btn-info {
            background-color: #adc5d1; /* グレイッシュブルー */
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
            width: 120px; /* 必要に応じて調整 */
            text-align: center;
            white-space: nowrap; /* 改行させない */
        }
    </style>
</head>
<body>
    <div class="admin-card">
        @if (session('success'))
        <div class="alert alert-success text-center" 
            style="background-color:#c8e6c9; color:#2e7d32; border:none; border-radius:8px;">
            {{ session('success') }}
        </div>
        @endif
        
    <h1>お問い合わせ一覧</h1>

        {{-- 一覧表示のテーブル例 --}}
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>メール</th>
                    <th class="action-col">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <a href="/contacts/{{ $contact->id }}/edit" class="btn btn-info btn-sm me-1">編集</a>
                            <form action="/contacts/{{ $contact->id }}/delete" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-sm">削除</button>
                            </form>
                        </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>