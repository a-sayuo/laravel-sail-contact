@extends('layouts.app')

@section('content')
    <h1>カテゴリ一覧</h1>
    <a href="{{ route('categories.create') }}" class="btn-center">新規カテゴリ作成</a>
    
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

            <div style="display: flex; align-items: center; gap: 15px;">

                <a href="{{ route('categories.edit', $category->id) }}"
                   style="color: #2e7d32; text-decoration: underline; font-size: 14px; display: block; line-height: 1;">
                    編集
                </a>

                <form action="{{ route('categories.destroy', $category->id) }}"
                      method="POST" 
                      style="margin: 0; display: block; line-height: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                    onclick="return confirm('本当に削除しますか?')"
                            style="
                                background: none; 
                                border: none; 
                                padding: 0; 
                                margin: 0;
                                color: #921e09; 
                                text-decoration: underline; 
                                cursor: pointer; 
                                font-size: 14px; 
                                font-family: inherit;
                                line-height: 1;
                                display: block;
                                height: auto;
                                width: auto;
                            ">削除</button>
                </form>

            </div>
        </li>
        @endforeach
    </ul>

@endsection