# NicoNicoRestClient

ニコニコ動画の各種API的な何かを使ってデータ取得するライブラリ。
ログイン（セッション）不要のもののみ対応。

## Supported APIs

### Public APIs

- スナップショットAPI
    - `https://site.nicovideo.jp/search-api-docs/snapshot`

### Private APIs

公式ドキュメントには記載されていないもの。

https://dic.nicovideo.jp/a/%E3%83%8B%E3%82%B3%E3%83%8B%E3%82%B3%E5%8B%95%E7%94%BBapi

https://w.atwiki.jp/nicoapi/


- ExtApi(getthumbinfo)
    - `https://ext.nicovideo.jp/api/getthumbinfo/***`
- FlApi(getrelation)
    - `https://flapi.nicovideo.jp/api/getrelation?video=***`
- CeApi
    - `https://api.ce.nicovideo.jp/api/v1/user.info?__format=json&user_id=2`
    - `https://api.ce.nicovideo.jp/nicoapi/v1/video.info?__format=json&v=***`
    - `https://api.ce.nicovideo.jp/nicoapi/v1/video.array?__format=json&v=***,***`
    - `https://api.ce.nicovideo.jp/nicoapi/v1/mylistgroup.get?__format=json&group_id=***`
    - `https://api.ce.nicovideo.jp/nicoapi/v1/mylist.list?__format=json&group_id=***&limit=50&from=0`
    - `https://api.ce.nicovideo.jp/nicoapi/v1/user.myvideo?__format=json&user_id=***`

### RSS feeds

- Rss
    - `https://www.nicovideo.jp/user/***/video?rss=atom`
    - `https://www.nicovideo.jp/user/***/mylist/***?rss=atom`


## usage

```
use NicoNicoRestClient\ClientFactory;
use NicoNicoRestClient\SnapshotApi\Query;

$client = ClientFactory::create(ClientFactory::SNAPSHOT_API);

$query = new Query(['q'=> 'test']);

$result = $client->list($query);

$videos = $result->getVideos();

foreach($videos as $video) {
    echo $video->getTitle() . PHP_EOL;
}
```

## with custom http client

```
// imprements Symfony\Contracts\HttpClient\HttpClientInterface;
$customHttpClient = ...;

$client = ClientFactory::create(ClientFactory::SNAPSHOT_API, $customHttpClient);
```
