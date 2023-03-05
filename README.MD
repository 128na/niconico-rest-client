# ニコ動APIクライアント

## 対応API

### 公開API

- スナップショットAPI https://site.nicovideo.jp/search-api-docs/snapshot

### 非公開API

- ExtApi(getthumbinfo)
    `https://ext.nicovideo.jp/api/getthumbinfo/***`
- FlApi(getrelation)
    `https://flapi.nicovideo.jp/api/getrelation?video=***`
- CeApi

### RSS

- Rss
    `https://www.nicovideo.jp/user/***/video?rss=atom`
    `https://www.nicovideo.jp/user/***/mylist/***?rss=atom`

# usage

```
use NicoNicoApi\ClientFactory;
use NicoNicoApi\SnapshotApi\Query;

$client = ClientFactory::create(ClientFactory::SNAPSHOT_API);

$query = new Query(['q'=> 'test']);

$result = $client->list($query);

$videos = $result->getVideos();
```

## with custom http client

```
// imprements Symfony\Contracts\HttpClient\HttpClientInterface;
$customHttpClient = ...;

$client = ClientFactory::create(ClientFactory::SNAPSHOT_API, $customHttpClient);

```
