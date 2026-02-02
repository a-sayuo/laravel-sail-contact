@extends('layouts.app') {{-- 共通レイアウトがある場合 --}}

@section('content')
<div class="login-container">
    <h1>ログイン</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" required autofocus>
        </div>

        <div>
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
        </div>

        <button type="submit">ログイン</button>
    </form>
</div>
@endsection