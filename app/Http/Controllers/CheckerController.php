<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; // Laravelのfetch的なやつ
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function index()
    {
        return view('checker');  // resources/views/checker.blade.php を表示
    }

    // APIデータをJSONで返す
    public function getData()
    {
        //tryの中でエラーが起きたらcatchに飛ぶ
        try {
            $youtubeData = $this->getYouTubeData();
            $twitchData = $this->getTwitchData();

            return response()->json([
                'youtube' => $youtubeData,
                'twitch' => $twitchData,
            ]);

        } catch (\Exception $e) {
            //エラーが起きても画面が壊れないよう空データを返す
            return response()->json([
                'youtube' => [],
                'twitch' => [],
                'error' => 'データの取得に失敗しました',
            ], 500);  //500はサーバーエラーを意味するHTTPステータスコード
        }
    }

    private function getYouTubeData()
    {
        $channels = [
            ['name' => 'ウェザーニュース', 'id' => 'UCNsidkYpIAQ4QaufptQBPHQ'],
            ['name' => '草津温泉', 'id' => 'UCbn5eHDjwmPC2K9RG8P0i_A'],
            ['name' => 'Revin', 'id' => 'UCmKowKbYkd8xwXHvYbssnbg'],
        ];

        $results = [];

        foreach ($channels as $channel) {
            //①配信中か確認
            $searchRes = Http::get('https://www.googleapis.com/youtube/v3/search', [
                'part' => 'snippet',
                'channelId' => $channel['id'],
                'eventType' => 'live',
                'type' => 'video',
                'key' => env('YOUTUBE_API_KEY'),
            ])->json();

            if (empty($searchRes['items'])) {
                //配信してない場合
                $results[] = [
                    'name' => $channel['name'],
                    'isLive' => false
                ];
                continue; //配信してない場合は次のチャンネルへ
            }

            //配信中なら動画IDを取得して詳細情報を取る
            $videoId = $searchRes['items'][0]['id']['videoId'];
            $title = $searchRes['items'][0]['snippet']['title'];

            $videoRes = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'liveStreamingDetails',
                'id' => $videoId,
                'key' => env('YOUTUBE_API_KEY'),
            ])->json();

            $liveDetails = $videoRes['items'][0]['liveStreamingDetails'] ?? [];

            $results[] = [
                'name' => $channel['name'],
                'isLive' => true,
                'title' => $title,
                'viewers' => $liveDetails['concurrentViewers'] ?? null,
                'startedAt' => $liveDetails['actualStartTime'] ?? null,
                'url' => "https://www.youtube.com/watch?v={$videoId}",
            ];
        }
        return $results;
    }

    private function getTwitchData()
    {
        //①アクセストークンを取得する
        $tokenRes = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
            'client_id' => env('TWITCH_CLIENT_ID'),
            'client_secret' => env('TWITCH_CLIENT_SECRET'),
            'grant_type' => 'client_credentials',
        ])->json();

        $token = $tokenRes['access_token'];

        //②そのトークンを使ってチャンネル情報を取得する
        $logins = ['butaman_suzukix', 'nukomaro2020', 'revin_of_twitch'];

        $names = [
            'butaman_suzukix' => 'ぶたまん',
            'nukomaro2020' => '保護猫ちゃんねる',
            'revin_of_twitch' => 'Revin',
        ];

        //リクエストのヘッダー
        $streamRes = Http::withHeaders([
            'Client-ID' => env('TWITCH_CLIENT_ID'),
            'Authorization' => "Bearer {$token}",
        ])->get('https://api.twitch.tv/helix/streams', [
            'user_login' => $logins,
        ])->json();

        //配信中の詳細データをuser_looginをキーにして整理する
        $liveMap = collect($streamRes['data'] ?? [])->keyBy('user_login');

        $results = [];
        foreach ($logins as $login) {
            if ($liveMap->has($login)) {
                $stream = $liveMap->get($login);
                $results[] = [
                    'name' => $names[$login],
                    'isLive' => true,
                    'title' => $stream['title'],
                    'viewers' => $stream['viewer_count'],
                    'startedAt' => $stream['started_at'],
                    'url' => "https://www.twitch.tv/{$login}",
                ];
            } else {
                $results[] = [
                    'name' => $names[$login],
                    'isLive' => false,
                ];
            }
        }

        return $results;
    }
}
