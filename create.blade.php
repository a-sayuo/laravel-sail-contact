@extends('layouts.app')

@section('content')
<div class="container">
    <h1>カテゴリ追加</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">カテゴリ名</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">追加</button>
    </form>
</div>
@endsection
