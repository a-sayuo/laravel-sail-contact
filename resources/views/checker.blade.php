<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>配信チェッカー</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 16px;
        }

        #results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 12px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 14px;
        }

        .card.live {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .card.offline {
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
    </style>
</head>

<body>
    <h1>配信チェッカー</h1>
    <p id="status">読み込み中...</p>
    <div id="results"></div>

    <script>
        async function loadData() {
            try {
                const res = await fetch('/checker/api');
                const data = await res.json();
                const all = [...data.youtube, ...data.twitch];

                all.sort((a, b) => b.isLive - a.isLive); //ライブ配信を上にする

                document.getElementById('results').innerHTML = all.map(s => {
                    if (s.isLive) {
                        //配信開始時間を「◯時間◯分前」に変換する
                        const started = s.startedAt ? timeSince(s.startedAt) : '';
                        return `
                            <div class="card live">
                            <span class="name">${s.name}</span>
                            <span class="badge-live">● LIVE</span>
                            <p class="title">${s.title}</p>
                            ${s.viewers ? `<p class="viewers">👥 ${Number(s.viewers).toLocaleString()}</p>` : ''}
                            ${started ? `<p class="viewers">🕐 ${started} から配信中</p>` : ''}
                            <a class="link" href="${s.url}" target="_blank">配信を見る →</a>
                            </div>`;
                    } else {
                        return `
                            <div class="card offline">
                            <span class="name">${s.name}</span>
                            <span class="badge-off">オフライン</span>
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
        setInterval(loadData, 30 * 60 * 1000); //30分ごとに更新
    </script>

</body>

</html>
