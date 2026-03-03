<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ編集</title>
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
            max-width: 700px;
            margin: 3rem auto; /* 中央寄せ */
        }
        h1 {
            color: #37474f; /* 濃いブルーグレイでアクセント */
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #90a4ae; /* グレイッシュブルー */
            border: none;
        }
        .btn-primary:hover {
            background-color: #607d8b;
        }
        .btn-secondary {
            background-color: #b0bec5;
            border: none;
        }
    </style>
</head>
<body>
    <div class="admin-card">
        <h1>お問い合わせ編集</h1>

        {{-- バリデーションエラー --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 編集フォーム --}}
        <form action="/contacts/{{ $contact->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">お名前</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $contact->name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $contact->email) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">お問い合わせ内容</label>
                <textarea name="message" class="form-control">{{ old('message', $contact->message) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">担当者</label>
                <select name="assigned_user_id" class="form-control">
                    <option value="">担当者を選択してください</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $contact->assigned_user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="text-center">
                <button class="btn btn-primary px-4">更新</button>
                <a href="/contacts" class="btn btn-secondary px-4">戻る</a>
            </div>
        </form>
    </div>
</body>
</html>