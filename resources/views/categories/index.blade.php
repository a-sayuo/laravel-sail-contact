@extends('layouts.admin')

@section('content')
<div class="admin-card">
    <h1>カテゴリ一覧</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-info">新規カテゴリ作成</a>
    
    <ul style="list-style: none; padding: 0; margin: 0;">
        @foreach ($categories as $category)
        <li style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        ">
            <span style="flex: 1;">{{ $category->name }}</span>

        <div class="d-flex">
        
            <a href="{{ route('categories.edit', $category->id) }}"
               class="btn btn-info btn-sm me-1">編集</a>
        
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('本当に削除しますか?')">削除</button>
            </form>
        
        </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection