<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>配信チェッカー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 12px;
        }

        .card-checker {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 14px;
        }

        .card-checker.live {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .card-checker.offline {
            background: #f9f9f9;
            color: #888;
        }

        .badge-live {
            display: inline-block;
            background: #ef4444;
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 6px;
        }

        .badge-off {
            display: inline-block;
            background: #ccc;
            color: #555;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 6px;
        }

        .name {
            font-weight: bold;
            font-size: 15px;
        }

        .title {
            font-size: 13px;
            margin: 8px 0 4px;
        }

        .viewers {
            font-size: 12px;
            color: #555;
        }

        .link {
            font-size: 13px;
            color: #3b82f6;
            text-decoration: none;
        }

        #status {
            font-size: 12px;
            color: #aaa;
            margin-bottom: 12px;
        }

        body {
            background-color: #f0f7f4;
            padding: 50px 0;
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <div
            style=" margin:auto; background:white;
                    padding:40px; border-radius:15px;
                    box-shadow:0 8px 20px rgba(0,0,0,0.05);
                    border-top:5px solid #8fbc8f;">

            {{-- お問い合わせフォームへ戻るリンク --}}
            <div class="text-end mb-3">
                <a href="/contact" style="color:#5caaad; text-decoration:none; font-size:0.9rem;">
                    ◀◀◀ お問い合わせフォームへ戻る
                </a>
            </div>

            <h1>配信チェッカー</h1>
            <p id="status">読み込み中...</p>
            <div id="results"></div>

            @verbatim
                <script>
                    async function loadData() {
                        try {
                            const res = await fetch('/checker/api');
                            const data = await res.json();

                            //PHP側でエラーが起きた時（500が返ってきた時）の処理
                            if (data.error) {
                                document.getElementById('status').textContent = '⚠️' + data.error;
                                return; //←ここで処理終了（下のコードを実行しない）
                            }

                            const all = [...data.youtube, ...data.twitch];

                            // 名前をキーにしてグループ化する
                            const grouped = {};
                            all.forEach(s => {
                                if (!grouped[s.name]) {
                                    // 初めて出てきた名前はそのまま入れる
                                    grouped[s.name] = {
                                        ...s,
                                        platforms: []
                                    };
                                }
                                // どのプラットフォームで配信中かを記録する
                                if (s.isLive) {
                                    grouped[s.name].isLive = true;
                                    grouped[s.name].platforms.push({
                                        title: s.title,
                                        viewers: s.viewers,
                                        startedAt: s.startedAt,
                                        url: s.url,
                                    });
                                }
                            });

                            // オブジェクトを配列に戻す
                            const merged = Object.values(grouped);

                            merged.sort((a, b) => b.isLive - a.isLive); //ライブ配信を上にする

                            document.getElementById('results').innerHTML = merged.map(s => {
                                if (s.isLive) {
                                    // 1人の中で「プラットフォームの数だけループ」してHTMLの塊を作る
                                    const platformsHtml = s.platforms.map(p => {
                                        // 配信開始時間をプラットフォーム(p)ごとに計算する
                                        const started = p.startedAt ? timeSince(p.startedAt) : '';

                                        return `
                                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #eee;">
                                        <p class="title" style="margin:0;">${p.title}</p>
                                        ${p.viewers ? `<p class="viewers">👥 ${Number(p.viewers).toLocaleString()}人</p>` : ''}
                                        ${started ? `<p class="viewers">🕐 ${started} から配信中</p>` : ''}
                                        <a class="link" href="${p.url}" target="_blank">配信を見る →</a>
                                        </div>`;
                                    }).join('');

                                    // カード本体を返す
                                    return `
                                        <div class="card-checker live">
                                        <span class="name">${s.name}</span>
                                        <span class="badge-live">● LIVE</span>
                                        ${platformsHtml} 
                                    </div>`;

                                } else {
                                    return `
                            <div class="card-checker offline">
                            <span class="name">${s.name}</span>
                            <span class="badge-off">OFF</span>
                            </div>`;
                                }
                            }).join('');

                            //最終更新時刻を表示する
                            document.getElementById('status').textContent = `最終更新: ${new Date().toLocaleTimeString('ja-JP')}`;

                        } catch (e) {
                            document.getElementById('status').textContent = 'データの読み込みに失敗しました。リロードして下さい。';
                        }
                    }

                    //「◯時間◯分前」を計算する関数
                    function timeSince(isoString) {
                        const diff = Math.floor((Date.now() - new Date(isoString).getTime()) / 1000); //秒
                        const hours = Math.floor(diff / 3600);
                        const minutes = Math.floor((diff % 3600) / 60);
                        if (hours > 0) {
                            return `${hours}時間${minutes}分前`;
                        }
                        return `${minutes}分前`;
                    }

                    loadData();
                    setInterval(loadData, 120 * 60 * 1000); //120分ごとに更新
                </script>
            @endverbatim

        </div>
    </div>
</body>

</html>
