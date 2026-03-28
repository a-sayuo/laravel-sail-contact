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

        {{-- 都道府県 --}}
        <div class="mb-3">
            <label class="form-label">都道府県</label>
            <select name="prefecture" id="prefecture" class="form-select">
                <option value="">選択してください</option>
                <option value="東京都" {{ old('prefecture') == '東京都' ? 'selected' : '' }}>東京都</option>
                <option value="千葉県" {{ old('prefecture') == '千葉県' ? 'selected' : '' }}>千葉県</option>
            </select>
        </div>

        {{-- 市区町村 --}}
        <div class="mb-3">
            <label class="form-label">市区町村</label>
            <select name="city" id="city" class="form-select">
                <option value="">都道府県を先に選んでください</option>
            </select>
        </div>

        {{-- カテゴリ --}}
        <div class="mb-3">
            <label for="name" class="form-label">カテゴリ</label>
            <select name="category_id" class="form-select">
                <option value="">未分類</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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

        <script>
            // 都道府県ごとの市区町村データ
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
                    '東大和市', '清瀬市', '東久留米市', '武蔵村山市', '多摩市',
                    '稲城市', '羽村市', 'あきる野市', '西東京市'
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

            // 都道府県のselectboxが変わったときに発動する処理
            document.getElementById('prefecture').addEventListener('change', function() {
                const prefecture = this.value; // 選ばれた都道府県
                const citySelect = document.getElementById('city'); // 市区町村のselectbox

                // 市区町村をいったんリセット
                citySelect.innerHTML = '<option value="">選択してください</option>';

                // 都道府県が選ばれていたら市区町村を流し込む
                if (prefecture && cityData[prefecture]) {
                    cityData[prefecture].forEach(function(city) {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        // バリデーションエラーで戻ってきたとき選択状態を復元
                        if (city === '{{ old('city') }}') {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                }
            });

            // ページ読み込み時にoldの値があれば都道府県を復元して市区町村も表示する
            window.addEventListener('load', function() {
                const prefecture = document.getElementById('prefecture').value;
                if (prefecture) {
                    document.getElementById('prefecture').dispatchEvent(new Event('change'));
                }
            });
        </script>
    </form>
@endsection
