<?php

declare(strict_types=1);

namespace NicoNicoRestClient;

use NicoNicoRestClient\ApiExt\Client as ApiExtClient;
use NicoNicoRestClient\ApiCe\Client as ApiCeClient;
use NicoNicoRestClient\ApiCe\MylistResult as ApiCeMylistResult;
use NicoNicoRestClient\ApiCe\UserResult as ApiCeUserResult;
use NicoNicoRestClient\ApiCe\VideoListResult as ApiCeVideoListResult;
use NicoNicoRestClient\ApiCe\VideoResult as ApiCeVideoResult;
use NicoNicoRestClient\ApiExt\Result as ApiExtResult;
use NicoNicoRestClient\Rss\Client as RssClient;
use NicoNicoRestClient\Web\Client as WebClient;
use NicoNicoRestClient\ApiSnapshot\Client as ApiSnapshotClient;
use NicoNicoRestClient\ApiSnapshot\Query as ApiSnapshotQuery;
use NicoNicoRestClient\ApiSnapshot\Result as ApiSnapshotResult;
use NicoNicoRestClient\Rss\Result as RssResult;
use NicoNicoRestClient\Web\Result as WebResult;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    protected ApiExtClient $apiExtClient;
    protected ApiCeClient $apiCeClient;
    protected RssClient $rssClient;
    protected WebClient $webClient;
    protected ApiSnapshotClient $apiSnapshotClient;

    public function __construct(protected HttpClientInterface $httpClient)
    {
        $this->apiExtClient = new ApiExtClient($httpClient);
        $this->apiCeClient = new ApiCeClient($httpClient);
        $this->rssClient = new RssClient($httpClient);
        $this->webClient = new WebClient($httpClient);
        $this->apiSnapshotClient = new ApiSnapshotClient($httpClient);
    }

    public function getApiExtClient(): ApiExtClient
    {
        return $this->apiExtClient;
    }
    public function getApiCeClient(): ApiCeClient
    {
        return $this->apiCeClient;
    }
    public function getRssClient(): RssClient
    {
        return $this->rssClient;
    }
    public function getWebClient(): WebClient
    {
        return $this->webClient;
    }
    public function getApiSnapshotClient(): ApiSnapshotClient
    {
        return $this->apiSnapshotClient;
    }

    public function apiCeUserInfo(int $userId): ApiCeUserResult
    {
        return $this->getApiCeClient()->userInfo($userId);
    }
    public function apiCeVideoInfo(string $videoId): ApiCeVideoResult
    {
        return $this->getApiCeClient()->videoInfo($videoId);
    }
    /**
     * @param array<string> $videoIds
     */
    public function apiCeVideoArray(array $videoIds): ApiCeVideoListResult
    {
        return $this->getApiCeClient()->videoArray($videoIds);
    }
    public function apiCeMylistGroup(int $groupId): ApiCeMylistResult
    {
        return $this->getApiCeClient()->mylistGroup($groupId);
    }
    public function apiCeMylistList(int $groupId, int $page = 1): ApiCeVideoListResult
    {
        return $this->getApiCeClient()->mylistList($groupId, $page);
    }
    public function apiCeUserMyVideo(int $userId, int $page = 1): ApiCeVideoListResult
    {
        return $this->getApiCeClient()->userMyVideo($userId, $page);
    }

    public function apiExtGet(string $videoId): ApiExtResult
    {
        return $this->getApiExtClient()->get($videoId);
    }

    public function apiSnapshotSearch(ApiSnapshotQuery $query): ApiSnapshotResult
    {
        return $this->getApiSnapshotClient()->search($query);
    }

    public function rssUser(int $userId, int $page = 1): RssResult
    {
        return $this->getRssClient()->user($userId, $page);
    }
    public function rssUserMylist(int $userId, int $mylistId, int $page = 1): RssResult
    {
        return $this->getRssClient()->userMylist($userId, $mylistId, $page);
    }
    public function rssMylist(int $mylistId, int $page = 1): RssResult
    {
        return $this->getRssClient()->mylist($mylistId, $page);
    }

    public function webSeries(int $seriesId): WebResult
    {
        return $this->getWebClient()->series($seriesId);
    }
}
