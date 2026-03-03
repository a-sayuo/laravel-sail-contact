@extends('layouts.admin')

@section('content')
<div class="admin-card">

    @if (session('success'))
        <div class="alert alert-success text-center"
            style="background-color:#c8e6c9; color:#2e7d32; border:none; border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    <h1>お問い合わせ一覧</h1>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メール</th>
                <th>カテゴリ</th>
                <th>担当者</th>
                <th class="action-col">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category->name ?? '未分類' }}</td>
                    <td>{{ $contact->assignedUser->name ?? '未対応' }}</td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <a href="/contacts/{{ $contact->id }}/edit" class="btn btn-info btn-sm me-1">編集</a>
                            <form action="/contacts/{{ $contact->id }}/delete" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $contacts->links() }}
</div>
@endsection