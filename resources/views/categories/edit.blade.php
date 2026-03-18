@extends('layouts.admin')

@section('content')
<div class="admin-card">
    <h1>カテゴリ編集</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">カテゴリ名</label>
            <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $category->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
