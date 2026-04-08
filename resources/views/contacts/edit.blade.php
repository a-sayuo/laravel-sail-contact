<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>お問い合わせ編集</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eceff1;
            /* 落ち着いたブルーグレイ */
        }

        .admin-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 700px;
            margin: 3rem auto;
            /* 中央寄せ */
        }

        h1 {
            color: #37474f;
            /* 濃いブルーグレイでアクセント */
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #90a4ae;
            /* グレイッシュブルー */
            border: none;
        }

        .btn-primary:hover {
            background-color: #607d8b;
        }

        .btn-secondary {
            background-color: #b0bec5;
            border: none;
        }

        .form-select {
            border: 1px solid #cfd8dc;
            /* 枠線を少し薄く */
            cursor: pointer;
        }

        .form-select:focus {
            border-color: #90a4ae;
            box-shadow: 0 0 0 0.25rem rgba(144, 164, 174, 0.25);
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
                <label class="form-label">都道府県</label>
                <select name="prefecture" id="prefecture" class="form-select">
                    <option value="">選択してください</option>
                    <option value="東京都" {{ old('prefecture', $contact->prefecture) == '東京都' ? 'selected' : '' }}>
                        東京都</option>
                    <option value="千葉県" {{ old('prefecture', $contact->prefecture) == '千葉県' ? 'selected' : '' }}>
                        千葉県</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">市区町村</label>
                <select name="city" id="city" class="form-select">
                    <option value="">都道府県を先に選んでください</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">お問い合わせ内容</label>
                <textarea name="message" class="form-control">{{ old('message', $contact->message) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">カテゴリ</label>
                <select name="category_id" class="form-select">
                    <option value="">未分類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $contact->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">担当者</label>
                <select name="assigned_user_id" class="form-select">
                    <option value="">担当者を選択してください</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $contact->assigned_user_id == $user->id ? 'selected' : '' }}>
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

        <script>
            const cityData = {
                '東京都': [
                    '千代田区', '中央区', '港区', '新宿区', '文京区',
                    '台東区', '墨田区', '江東区', '品川区', '目黒区',
                    '大田区', '世田谷区', '渋谷区', '中野区', '杉並区',
                    '豊島区', '北区', '荒川区', '板橋区', '練馬区',
                    '足立区', '葛飾区', '江戸川区', '八王子市', '立川市',
                    '武蔵野市', '三鷹市', '青梅市', '府中市', '昭島市',
                    '調布市', '町田市', '小金井市', '小平市', '日野市',
                    '東村山市', '国分寺市', '国立市', '福生市', '狛江市',
                    '東大和市', '清瀬市', '東久留米市', '武蔵村山市',
                    '多摩市', '稲城市', '羽村市', 'あきる野市', '西東京市'
                ],
                '千葉県': [
                    '千葉市', '銚子市', '市川市', '船橋市', '館山市',
                    '木更津市', '松戸市', '野田市', '茂原市', '成田市',
                    '佐倉市', '東金市', '旭市', '習志野市', '柏市',
                    '勝浦市', '市原市', '流山市', '八千代市', '我孫子市',
                    '鴨川市', '鎌ケ谷市', '君津市', '富津市', '浦安市',
                    '四街道市', '袖ケ浦市', '八街市', '印西市', '白井市',
                    '富里市', '南房総市', '匝瑳市', '香取市', '山武市',
                    'いすみ市', '大網白里市'
                ]
            };

            function updateCitySelect(selectedCity) {
                const prefecture = document.getElementById('prefecture').value;
                const citySelect = document.getElementById('city');

                // 市区町村をいったんリセット
                citySelect.innerHTML = '<option value="">選択してください</option>';

                // 都道府県が選ばれていたら市区町村を流し込む
                if (prefecture && cityData[prefecture]) {
                    cityData[prefecture].forEach(function(city) {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        // バリデーションエラーで戻ってきたとき選択状態を復元
                        if (city === selectedCity) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                }
            }

            // 都道府県のselectboxが変わったときに発動する処理
            document.getElementById('prefecture').addEventListener('change', function() {
                updateCitySelect('');
            });

            // ページ読み込み時に保存済みの値を復元する
            window.addEventListener('load', function() {
                const savedCity = '{{ old('city', $contact->city) }}';
                const prefecture = document.getElementById('prefecture').value;
                if (prefecture) {
                    updateCitySelect(savedCity);
                }
            });
        </script>

        <hr class="my-4">

        <h3>社内メモ</h3>

        <ul class="list-group mb-3">
            @foreach ($contact->memos as $memo)
                <li class="list-group-item">
                    {{ $memo->body }}
                    <div class="text-muted small">
                        {{ $memo->created_at->format('Y-m-d H:i') }}
                    </div>
                </li>
            @endforeach
        </ul>

        <form action="/memos" method="POST">
            @csrf

            <input type="hidden" name="contact_id" value="{{ $contact->id }}">

            <div class="mb-3">
                <label class="form-label">新しいメモ</label>
                <textarea name="body" class="form-control" rows="3"></textarea>
            </div>

            <button class="btn btn-secondary">メモを追加</button>
        </form>



    </div>
</body>

</html>
