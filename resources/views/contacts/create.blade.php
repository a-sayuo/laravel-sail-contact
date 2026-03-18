@extends('layouts.guest_contact')
@section('content')
<h2 class="text-center mb-4">お問い合わせフォーム</h2>

@if (session('success'))
    <div class="alert alert-success shadow-sm mb-4" style="background-color: #d1e7dd; color: #0f5132; border: none;">
        {{ session('success') }}
    </div>
@endif

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

    {{-- ★ ここにカテゴリ選択を追加 ★ --}}
        <div class="mb-3">
            <label for="name" class="form-label">カテゴリ</label>
            <select name="category_id" class="form-select">
            <option value="">未分類</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
            </select>
        </div>

    <div class="mb-3">
        <label class="form-label">お問い合わせ内容</label>
        <textarea name="message" class="form-control" rows="8" style="width: 100%; display: block;">{{ old('message') }}</textarea>
    </div>

    <div class="text-center">
        <button class="btn btn-green px-4">送信</button>
    </div>
</form>

@endsection