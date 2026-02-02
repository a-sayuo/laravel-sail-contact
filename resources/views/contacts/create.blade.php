<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせフォーム</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e8f5e9; 
        }
        .form-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 2rem;
            max-width: 600px;
            margin: 3rem auto; /* 中央寄せ */
        }
        h1 {
            color: #779679; 
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #66bb6a; 
            border: none;
        }
        .btn-primary:hover {
            background-color: #43a047;
        }
    </style>
</head>
<body>
    <div class="form-card">
        <h1>お問い合わせ</h1>

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

        {{-- フォーム --}}
        <form action="/contact" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">お名前</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">お問い合わせ内容</label>
                <textarea name="message" class="form-control">{{ old('message') }}</textarea>
            </div>

            <div class="text-center">
                <button class="btn btn-primary px-4">送信</button>
            </div>
        </form>
    </div>
</body>
</html>