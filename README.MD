# NicoNicoRestClient

ニコニコ動画の各種API的な何かを使ってデータ取得するライブラリ。
ログイン（セッション）不要のもののみ対応。

## install

```
composer require 128na/niconico-rest-client
```

## Usage

```
use NicoNicoRestClient\ClientFactory;
use NicoNicoRestClient\ApiSnapshot\Query;

$client = ClientFactory::create(ClientFactory::API_SNAPSHOT);

$query = new Query(['q'=> 'test']);
$result = $client->list($query);
echo $result->statusOk() ? 'ok' : 'fail';

$videos = $result->getVideos();

foreach($videos as $video) {
    echo $video->getTitle() . PHP_EOL;
}
```

## With custom http client

`Symfony\Contracts\HttpClient\HttpClientInterface` を実装しているクライアントであれば利用できます。

キャッシュ機能付きのクライアントを使用する例

```
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;

$store = new Store('/path/to/cache/storage/');
$httpClient = HttpClient::create();
$cachingHttpClient = new CachingHttpClient($httpClient, $store);

$client = ClientFactory::create(ClientFactory::API_SNAPSHOT, $cachingHttpClient);
```

# Supported APIs

## Public APIs

公式から提供されているもの。

https://site.nicovideo.jp/search-api-docs/snapshot

### スナップショットAPI

```
https://api.search.nicovideo.jp/api/v2/snapshot/video/contents/search
```

```
$client = ClientFactory::create(ClientFactory::API_SNAPSHOT);

// クエリパラメーターを直接指定可能
$query = new Query(['q'=> 'test']);
// setメソッドでの設定も可能
$quert->setLimit(10);

$result = $client->list($query);
echo $result->statusOk() ? 'ok' : 'fail';

$videos = $result->getVideos();

foreach($videos as $video) {
    echo $video->getTitle() . PHP_EOL;
}
```

## Private APIs

公式には記載されていないがログイン不要なもの。動作保証外。

https://dic.nicovideo.jp/a/%E3%83%8B%E3%82%B3%E3%83%8B%E3%82%B3%E5%8B%95%E7%94%BBapi

https://w.atwiki.jp/nicoapi/

非公開だけど廃止時にアナウンスされる（やさしい

https://www.google.com/search?q=api+site%3Ahttps%3A%2F%2Fblog.nicovideo.jp%2Fniconews

### ExtApi(getthumbinfo)

動画単体の情報を取得可能。
```
https://ext.nicovideo.jp/api/getthumbinfo/***
```

```
$client = ClientFactory::create(ClientFactory::API_EXT);

$result = $client->get('sm0');
echo $result->statusOk() ? 'ok' : 'fail';

$video = $result->getVideo();

echo $video->getTitle() . PHP_EOL;
```


### CeApi

```
https://api.ce.nicovideo.jp/api/v1/user.info?__format=json&user_id=2
https://api.ce.nicovideo.jp/nicoapi/v1/video.info?__format=json&v=***
https://api.ce.nicovideo.jp/nicoapi/v1/video.array?__format=json&v=***,***
https://api.ce.nicovideo.jp/nicoapi/v1/mylistgroup.get?__format=json&group_id=***
https://api.ce.nicovideo.jp/nicoapi/v1/mylist.list?__format=json&group_id=***&limit=50&from=0
https://api.ce.nicovideo.jp/nicoapi/v1/user.myvideo?__format=json&user_id=***
```

※group_id=mylist_id

```
$client = ClientFactory::create(ClientFactory::API_CE);

$videoResult = $client->videoInfo('sm0');
$videosResult = $client->videoArray(['sm0', 'sm1']);
$mylistResult = $client->mylistGroup($mylistId);
$videosResult = $client->mylistList($mylistId, $page);
$userResult = $client->userInfo($userId);
$videosResult = $client->userMyVideo($userId, $page);
```


## その他

APIではないがデータ取得可能なもの。

### Rss

```
https://www.nicovideo.jp/user/***/video?rss=atom
https://www.nicovideo.jp/user/***/mylist/***?rss=atom
```

```
$client = ClientFactory::create(ClientFactory::RSS);

$videosResult = $client->user($userId, $page);
$videosResult = $client->userMylist($userId, $mylistId, $page);
$videosResult = $client->mylist($mylistId, $page);
```

- Web

シリーズを取得出来る方法がなかったので無理やる作った感。

```
https://sp.nicovideo.jp/series/***
```

```
$client = ClientFactory::create(ClientFactory::WEB);

$videosResult = $client->series($seriesId);
```

### Video fields

API仕様によりできるフィールドが異なるため注意。

|項目名|Method|Snapshot|Ext|Rss|Ce|Ce|Web|説明|
|:----|:----|:----|:----|:----|:----|:----|:----|:----|
|APIs| |list|get|userMylist, mylist, user|videoInfo|videoArray, mylistGroup, mylistList, userMyVideo|series| |
|動画ID|getContentId|contentId|video_id|〇|video.id|video.id|[data-watch_id]| |
|再生ページURL|getWatchUrl|〇|watch_url|link.@attributes.href|〇|〇|[data-video_url]| |
|動画タイトル|getTitle|title|title|title|title|title|[data-title]| |
|動画説明文|getDescription|description|description|〇|description|description|×| |
|サムネイルURL|getThumbnailUrl|thumbnailUrl|thumbnail_url|media_thumbnail.@attributes.url|video.thumbnail_url|video.thumbnail_url|[data-original]| |
|投稿日時|getStartTime|startTime|first_retrieve|published|video.first_retrieve|video.first_retrieve|.video-item-date (時刻無し、日付のみ)| |
|再生時間（h:i:s）|getLengthString|〇|length|×|〇|〇|〇|60分未満はi:s|
|再生時間（秒）|getLengthSeconds|lengthSeconds|〇|×|video.length_in_seconds|video.length_in_seconds|[data-video_length]| |
|再生数|getViewCounter|viewCounter|view_counter|×|video.view_counter|video.view_counter|[data-view_counter]| |
|コメント数|getCommentCounter|commentCounter|comment_num|×|video.length_in_seconds|video.length_in_seconds|[data-comment_counter]| |
|マイリスト数|getMylistCounter|mylistCounter|mylist_counter|×|video.mylist_counter|video.mylist_counter|[data-mylist_counter]| |
|いいね数|getLikeCounter|likeCounter|×|×|×|×|[data-like_counter]| |
|最後のコメント日時|getLastCommentTime|lastCommentTime|×|×|×|×|×| |
|最後のコメント本文|getLastResBody|lastResBody|last_res_body|×|×|×|×| |
|タグ一覧|getTags|tags|tags.tag|×|tags.tag_info.tag|×|×| |
|ジャンル名|getGenre|genre|genre|×|video.genre.label|video.genre.label|×| |
|オーナータイプ|getOwnerType|〇|〇|×|video.option_flag_community|video.option_flag_community|[data-owner_type]|user or channel|
|オーナーID|getOwnerId|userId, channelId|user_id, ch_id|×|video.user_id, video.community_id|video.user_id, video.community_id|[data-owner_id]| |
| | | | | | | | | |
|オーナー名|getOwnerName|×|user_nickname, ch_name|×|×|×|[data-owner_name]| |
|オーナーアイコンURL|getOwnerIconUrl|×|user_icon_url, ch_icon_url|×|×|×|[data-owner_icon_url]| |
|オーナー詳細URL|getOwnerUrl|×|×|×|×|×|[data-owner_url]| |
|サムネイル形式|getThumbType|×|thumb_type|×|×|×|×| |
|埋め込み可|getEmbeddable|×|embeddable|×|×|×|×| |
|再生にログイン必須|getNoLivePlay|×|no_live_play|×|×|×|×| |
|動画形式|getMovieType|×|movie_type|×|×|×|×|flv,mp4など|
|高画質容量|getSizeHigh|×|size_high|×|×|×|×|bytes|
|低画質容量|getSizeLow|×|size_low|×|×|×|×|bytes|
|動画説明文(HTML)|getDescriptionHTML|×|×|content|×|×|×| |
|削除フラグ|getDeleted|×|×|×|video.deleted|video.deleted|×| |
|マイリストアイテムID|getMylistItemId|×|×|×|×|mylist.item_id|×|mylistListのみ|
|マイリストアイテムの説明|getMylistDescription|×|×|×|×|mylist.description|×|mylistListのみ|
|マイリストアイテム登録日時|getMylistCreateTime|×|×|×|×|mylist.create_time|×|mylistListのみ|
