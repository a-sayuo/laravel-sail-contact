<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* 全体の背景：淡いグリーン */
        body {
            background-color: #f0f7f4;
            padding: 50px 0;
            font-family: 'sans-serif';
        }

        /* フォームの白い枠 */
        .contact-card {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border-top: 5px solid #8fbc8f;
            /* 上部にアクセントのグリーン */
        }

        /* カスタムグリーンボタン（強制上書き版） */
        .btn-green {
            background-color: #5cad67 !important;
            border-color: #295239 !important;
            color: white !important;
            font-weight: bold;
            padding: 10px 30px;
            display: inline-block;
        }

        .btn-green:hover {
            background-color: #34694a !important;
            border-color: #234933 !important;
            color: white !important;
        }

        /* 入力フォームの枠線も少しグリーンに */
        .form-control:focus {
            border-color: #a3d1b7;
            box-shadow: 0 0 0 0.25rem rgba(103, 180, 134, 0.25);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="contact-card">
            <!-- チェッカーリンク -->
            <div class="text-end mb-3">
                <a href="/checker" style="color: #5caaad; text-decoration: none; font-size: 0.9rem;">
                    ▶▶▶ 配信チェッカー
                </a>
            </div>

            @yield('content')
        </div>
    </div>
</body>

</html>
